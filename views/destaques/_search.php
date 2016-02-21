<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DestaquesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="destaques-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idDestaques') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'dataEntrada') ?>

    <?= $form->field($model, 'dataSaida') ?>

    <?= $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
