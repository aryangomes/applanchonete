<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Cardapio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cardapio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data')->widget(DateControl::classname(), [
			'type'=>DateControl::FORMAT_DATE,
			'ajaxConversion'=>false,
			'options' => [
			
			'pluginOptions' => [
			'autoclose' => true
			]
			],
			'displayFormat' => 'dd/MM/yyyy',
			'language'=>'pt',
			]);?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
