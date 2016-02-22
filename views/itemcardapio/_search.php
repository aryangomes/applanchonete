<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ItemcardapioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="itemcardapio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idCardapio') ?>

    <?= $form->field($model, 'idProduto') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'ordem') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
