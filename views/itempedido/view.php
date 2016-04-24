<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Itempedido */

$this->title = 'Pedido: ' .$model->idPedido;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Itempedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itempedido-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'idPedido' => $model->idPedido, 'idProduto' => $model->idProduto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'idPedido' => $model->idPedido, 'idProduto' => $model->idProduto], [
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
            'idProduto',
            'quantidade',
            'total',
            ],
            ]) ?>

        </div>
