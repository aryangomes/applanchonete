<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComandaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comanda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idComanda') ?>

    <?= $form->field($model, 'desconto') ?>

    <?= $form->field($model, 'totalPago') ?>

    <?= $form->field($model, 'dataHoraAbertura') ?>

    <?= $form->field($model, 'dataHoraFechamento') ?>

    <?php // echo $form->field($model, 'descricao') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'totalPedidos') ?>

    <?php // echo $form->field($model, 'mesaIdMesa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
