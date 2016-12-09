<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelCardapio app\models\Cardapio */
/* @var $itensCardapio array */
/* @var $insumosProdutos array */

$this->title = $modelCardapio->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Cardápios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cardapio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Alterar', ['update', 'id' => $modelCardapio->idCardapio], ['class' => 'btn btn-primary',
            'title'=>'Clique para ir para a tela de alteração dos dados de Cardápio']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $modelCardapio->idCardapio], [
            'class' => 'btn btn-danger',
            'title' => 'Clique para apagar esse Cardápio',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelCardapio,
        'attributes' => [

            [

                'attribute' => 'data',

                'value' => isset($modelCardapio->data) ?
                        Yii::$app->formatter->asDate($modelCardapio->data, 'dd/M/Y'):null
            ],
            'titulo',
        ],
    ]) ?>

</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Produto</th>
            <th>Preço</th>
            <th>Categoria</th>
            <th>Ingredientes</th>
            <th>Foto</th>

        </tr>
        </thead>
        <tbody>
        <?php
        if (count($itensCardapio) > 0) {
            $count = 0;
            foreach ($itensCardapio as $ic) {

                ?>
                <tr>
                    <td><?= $ic->produto->nome ?></td>
                    <td>R$ <?= number_format($ic->produto->valorVenda, 2) ?></td>
                    <td><?= $ic->produto->categoria->nome ?></td>
                    <td><?= implode(", ", $insumosProdutos[$count]) ?></td>
                    <td><?= isset($ic->produto->foto) ?
                            Html::img('data:image/jpeg;base64,' . base64_encode($ic->produto->foto),
                                ['class' => 'img-responsive',
                                    'width' => '200'])
                            : 'Sem imagem cadastrada' ?></td>

                </tr>
                <?php
                $count++;
            }
        }
        ?>
        </tbody>
    </table>
