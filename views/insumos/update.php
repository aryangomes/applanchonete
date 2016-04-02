<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Insumos */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Insumos',
]) . ' ' . $model->idprodutoVenda;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Insumos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idprodutoVenda, 'url' => ['view', 'id' => $model->idprodutoVenda]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="insumos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
