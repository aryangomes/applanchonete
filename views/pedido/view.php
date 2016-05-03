<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = 'Pedido: '.$model->idPedido. ' | Situação Atual: '.$model->situacaopedido->titulo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->idPedido], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idPedido], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'method' => 'post',
            ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            'idPedido',
            'totalPedido',
            ['attribute'=>'situacaopedido',
            'label'=>'Situação Atual',
            'value'=>$model->situacaopedido->titulo],
            ],
            ]) ?>

        </div>
