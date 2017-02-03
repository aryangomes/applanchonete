<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Situacaopedido */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Situação Pedido',
]) . ': ' . $model->titulo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Situações Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Situação Pedido: ' . $model->titulo, 'url' => ['view', 'id' => $model->idSituacaoPedido]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="situacaopedido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
