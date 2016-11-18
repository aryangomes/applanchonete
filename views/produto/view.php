<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use  yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $modelProduto app\models\Produto */
/* @var $produtoVenda app\models\Produto */


$this->title = 'Produto ' . $modelProduto->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $modelProduto->idProduto], ['class' => 'btn btn-primary',
            'title'=>'Clique para ir para a tela de alteração dos dados do Produto']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelProduto->idProduto], [
            'class' => 'btn btn-danger',
            'title' => 'Clique para apagar esse Produto',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

        <?php
        echo (!$modelProduto->isInsumo) ?
            Html::a(Yii::t('app', 'Alterar valor de venda'), ['definirvalorprodutovenda', 'idProduto' => $modelProduto->idProduto],
                ['class' => 'btn btn-success',
                    'title' => 'Clique para alterar o valor do Prouto Venda',]) : '' ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelProduto,
        'attributes' => [
            // 'idProduto',
            'nome',

            [
                'attribute' => 'valorVenda',
                'format' => 'text',
                'value' => 'R$ ' . \Yii::$app->formatter->asDecimal($modelProduto->valorVenda, 2),
                'visible' => !($modelProduto->isInsumo),
            ],
            [
                'attribute' => 'isInsumo',
                'format' => 'text',
                'value' => $modelProduto->isInsumo ? 'Sim' : 'Não',
                'visible' => $modelProduto->isInsumo,
            ],
            [
                'attribute' => 'quantidadeMinima',
                'format' => 'text',
                'value' => $modelProduto->quantidadeMinima,
                'visible' => $modelProduto->isInsumo,
            ],
            [
                'label' => 'Categoria',
                'format' => 'text',
                'value' => $modelProduto->nomeCategoria,

            ],
            [
                'attribute' => 'quantidadeEstoque',
                'format' => 'text',
                'value' => $modelProduto->quantidadeEstoque,
                'visible' => $modelProduto->isInsumo,
            ],
            [
                'label' => 'Preço de custo',
                'format' => 'raw',
                'value' => $modelProduto->isInsumo ? null :
                    'R$ ' . \Yii::$app->formatter
                        ->asDecimal(($modelProduto->calculoPrecoProduto($modelProduto->idProduto)), 2) .
                    Yii::$app->session->getFlash('custofixozerados'),
                'visible' => !($modelProduto->isInsumo),
            ],
            [
                'attribute' => 'foto',
                'format' => 'raw',
                'value' => isset($modelProduto->foto) ? Html::img('data:image/jpeg;base64,' . base64_encode($modelProduto->foto),
                    ['class'=>'img-responsive', 'width' => '500'])
                    : 'Sem imagem cadastrada',

            ],

        ],
    ]) ?>

    <div class="panel panel-default">

        <?php
        if (isset($insumos) && !($produtoVenda->isInsumo)) {

        ?>
        <div class="panel-heading">Insumos de <?= $modelProduto->nome ?></div>
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
                            'id' => $insumo->idprodutoInsumo,
                        ]))
                        ?></td>
                    <td><?php
                        echo
                        ($insumo->quantidade > 1) ? $insumo->quantidade . ' ' . $insumo->unidade . 's' :
                            $insumo->quantidade . ' ' . $insumo->unidade;
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

    if (!$modelProduto->isInsumo) {
        echo Html::a('Avaliar produto <i class="fa fa-line-chart"></i>',
            Url::toRoute(['produto/avaliacaoproduto', 'idproduto' => $modelProduto->idProduto]),
            ['class' => 'btn btn-primary btn-block',
                'title' => 'Clique para avaliar o Prouto Venda']);
    }
    ?>
</div>
