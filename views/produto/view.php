<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use  yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Produto */

$this->title = 'Produto '.$model->nome;
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
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
            ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
           // 'idProduto',
            'nome',

            [
            'attribute'=>  'valorVenda',
            'format'=>'text',
            'value'=> $model->valorVenda,
            'visible'=>!($model->isInsumo),
            ],
            [
            'attribute'=>  'isInsumo',
            'format'=>'text',
            'value'=> $model->isInsumo ? 'Sim' : 'Não',
            'visible'=>$model->isInsumo,
            ],
            [
            'attribute'=>  'quantidadeMinima',
            'format'=>'text',
            'value'=> $model->quantidadeMinima,
            'visible'=>$model->isInsumo,
            ],
            [
            'label'=>  'Categoria',
            'format'=>'text',
            'value'=> $model->nomeCategoria,

            ],
            [
            'attribute'=>  'quantidadeEstoque',
            'format'=>'text',
            'value'=> $model->quantidadeEstoque,
            'visible'=>$model->isInsumo,
            ],
            [
            'label'=>'Preço sugerido',
            'format'=>'text',
            'value'=> $model->isInsumo ? null :  ($model->calculoprecoproduto($model->idProduto)),
            'visible'=>!($model->isInsumo),
            ],

            ],
            ]) ?>


<?php 

if (!$model->isInsumo) {

    echo $model->lucroproduto($model->idProduto);
    echo Html::a('Avaliar produto <i class="fa fa-line-chart"></i>', 
        Url::toRoute(['produto/avaliacaoproduto', 'idproduto'=>$model->idProduto]),
        ['class' =>  'btn btn-primary btn-block']);
}
?>
</div>
