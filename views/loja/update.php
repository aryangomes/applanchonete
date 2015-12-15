<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Loja */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Loja',
]) . ' ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lojas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->nome]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="loja-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
