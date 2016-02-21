<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Destaques */

$this->title = 'Update Destaques: ' . ' ' . $model->idDestaques;
$this->params['breadcrumbs'][] = ['label' => 'Destaques', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idDestaques, 'url' => ['view', 'id' => $model->idDestaques]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="destaques-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
