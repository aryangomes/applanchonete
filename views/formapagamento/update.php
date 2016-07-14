<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Formapagamento */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Formapagamento',
]) . $model->idTipoPagamento;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Formapagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idTipoPagamento, 'url' => ['view', 'id' => $model->idTipoPagamento]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="formapagamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
