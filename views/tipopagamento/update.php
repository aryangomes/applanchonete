<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipopagamento */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tipopagamento',
]) . $model->idTipoPagamento;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipopagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idTipoPagamento, 'url' => ['view', 'id' => $model->idTipoPagamento]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tipopagamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
