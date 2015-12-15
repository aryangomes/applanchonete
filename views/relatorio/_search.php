<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RelatorioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="relatorio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idrelatorio') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'datageracao') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'inicio_intervalo') ?>

    <?php // echo $form->field($model, 'fim_intervalo') ?>

    <?php // echo $form->field($model, 'usuario_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
