<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use  yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Produto */

$this->title = 'Produto ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->idProduto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idProduto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <?php
        echo  (!$model->isInsumo) ?
        Html::a(Yii::t('app', 'Alterar valor de venda'), ['definirvalorprodutovenda', 'idProduto' => $model->idProduto],
            ['class' => 'btn btn-success']) : ''?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'idProduto',
            'nome',

            [
                'attribute' => 'valorVenda',
                'format' => 'text',
                'value' => 'R$ ' .\Yii::$app->formatter->asDecimal($model->valorVenda,2),
                'visible' => !($model->isInsumo),
            ],
            [
                'attribute' => 'isInsumo',
                'format' => 'text',
                'value' => $model->isInsumo ? 'Sim' : 'Não',
                'visible' => $model->isInsumo,
            ],
            [
                'attribute' => 'quantidadeMinima',
                'format' => 'text',
                'value' => $model->quantidadeMinima,
                'visible' => $model->isInsumo,
            ],
            [
                'label' => 'Categoria',
                'format' => 'text',
                'value' => $model->nomeCategoria,

            ],
            [
                'attribute' => 'quantidadeEstoque',
                'format' => 'text',
                'value' => $model->quantidadeEstoque,
                'visible' => $model->isInsumo,
            ],
            [
                'label' => 'Preço de custo',
                'format' => 'raw',
                'value' => $model->isInsumo ? null :
                    'R$ ' .\Yii::$app->formatter
                        ->asDecimal(($model->calculoPrecoProduto($model->idProduto)),2) .
                    Yii::$app->session->getFlash('custofixozerados'),
                'visible' => !($model->isInsumo),
            ],

        ],
    ]) ?>

    <div class="panel panel-default">
       
        <?php
        if (isset($insumos) && !($produtoVenda->isInsumo)) {

        ?>
        <div class="panel-heading">Insumos de <?= $model->nome ?></div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <?php
            foreach ($insumos as $insumo) {
                ?>
                <tr>
                    <td><?= Html::a($insumo['produtoInsumo']->nome, Url::toRoute(['view',
                           'idprodutoVenda' => $produtoVenda->idProduto,
                            'id' => $insumo->idprodutoInsumo]))
                        ?></td>
                      <td><?php
                          echo
                            ($insumo->quantidade>1) ? $insumo->quantidade .' '. $insumo->unidade.'s':
                                $insumo->quantidade .' '. $insumo->unidade;
                          ?></td>

                </tr>

                <?php

            }

            ?>
        </table>
        </div>
        <?php
        }
        ?>

    <?php

    if (!$model->isInsumo) {
        echo Html::a('Avaliar produto <i class="fa fa-line-chart"></i>',
            Url::toRoute(['produto/avaliacaoproduto', 'idproduto' => $model->idProduto]),
            ['class' => 'btn btn-primary btn-block']);
    }
    ?>
</div>
