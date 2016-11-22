<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $modelContasapagar app\models\Contasapagar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contasapagar-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($modelContasapagar, 'idconta')->hiddenInput([$modelContasapagar->idconta])->label(false) ?>



	<?= $form->field($modelContasapagar, 'dataVencimento')->widget(DateControl::classname(), [
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
			<?= Html::submitButton($modelContasapagar->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'),
				['class' => $modelContasapagar->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
					'title'=>$modelContasapagar->isNewRecord ? 'Clique para cadastrar uma nova Conta a Pagar':
						'Clique para salvar os dados da Conta A Pagar']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
