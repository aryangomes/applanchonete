<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Custofixo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Custofixo',
]) . $model->idconta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Custofixos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idconta, 'url' => ['view', 'id' => $model->idconta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="custofixo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tiposCustoFixo'=>$tiposCustoFixo
    ]) ?>

</div>
