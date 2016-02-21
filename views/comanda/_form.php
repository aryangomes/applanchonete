<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\Comanda */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comanda-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'desconto')->widget(MaskMoney::classname(), [
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]); ?>
    
    <?= $form->field($model, 'totalPago')->widget(MaskMoney::classname(), [
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]); ?>
    <?= $form->field($model, 'dataHoraAbertura')->textInput() ?>

    <?= $form->field($model, 'dataHoraFechamento')->textInput() ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'totalPedidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mesaIdMesa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
