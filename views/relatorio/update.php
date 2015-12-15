<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Relatorio */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Relatorio',
]) . ' ' . $model->idrelatorio;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relatorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idrelatorio, 'url' => ['view', 'id' => $model->idrelatorio]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="relatorio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
