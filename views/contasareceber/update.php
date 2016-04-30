<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contasareceber */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Contasareceber',
]) . $model->idconta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contasarecebers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idconta, 'url' => ['view', 'id' => $model->idconta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contasareceber-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
