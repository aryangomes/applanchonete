<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MesaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mesa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idMesa') ?>

    <?= $form->field($model, 'numeroDaMesa') ?>

    <?= $form->field($model, 'disponivel') ?>

    <?= $form->field($model, 'alerta') ?>

    <?= $form->field($model, 'qrcode') ?>

    <?php // echo $form->field($model, 'chave') ?>

    <?php // echo $form->field($model, 'cont') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
