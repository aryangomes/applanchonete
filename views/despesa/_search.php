<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DespesaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="despesa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iddespesa') ?>

    <?= $form->field($model, 'nomedespesa') ?>

    <?= $form->field($model, 'valordespesa') ?>

    <?= $form->field($model, 'situacaopagamento') ?>

    <?= $form->field($model, 'datavencimento') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
