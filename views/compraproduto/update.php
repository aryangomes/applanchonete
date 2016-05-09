<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Compraproduto */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Compraproduto',
]) . $model->idCompra;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compraprodutos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idCompra, 'url' => ['view', 'idCompra' => $model->idCompra, 'idProduto' => $model->idProduto]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="compraproduto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
