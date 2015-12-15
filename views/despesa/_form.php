<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model app\models\Despesa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="despesa-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'nomedespesa')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'valordespesa')->widget(MaskMoney::classname(), [
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]); ?>

		<?= $form->field($model, 'situacaopagamento')->dropDownList([1=>'Pago',0=>'Não Pago'], ['prompt'=>'Selecione a situação de pagamento da despesa']) ?>

		<?= $form->field($model, 'datavencimento')->widget(DateControl::classname(), [
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

			<div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
