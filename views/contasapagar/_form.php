<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model app\models\Contasapagar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contasapagar-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'idconta')->hiddenInput([$model->idconta])->label(false) ?>


	<?/*= $form->field($model, 'situacaoPagamento')->dropDownList(
	[1=>'Paga',0=>'Não paga'],['prompt'=>'Seleciona a situação do pagamento']) */?>

	<?= $form->field($model, 'dataVencimento')->widget(DateControl::classname(), [
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
			<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
