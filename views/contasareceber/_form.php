<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contasareceber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contasareceber-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idconta')->textInput() ?>

    <?= $form->field($model, 'dataHora')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
