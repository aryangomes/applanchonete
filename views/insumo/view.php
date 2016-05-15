<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Insumos */

$this->title = 'Insumo: ' . $model->nomeInsumo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Insumos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insumos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'),['update', 'idprodutoVenda' => $model->idprodutoVenda, 'idprodutoInsumo' => $model->idprodutoInsumo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'idprodutoVenda' => $model->idprodutoVenda, 'idprodutoInsumo' => $model->idprodutoInsumo], [
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
            
            //'idprodutoVenda',
           // 'idprodutoInsumo',
            [
            'label'=>'Produto Venda',
            'value' =>$model->nomeprodutovenda,
            ],
            'quantidade',
            'unidade',
            ],
            ]) ?>

        </div>
