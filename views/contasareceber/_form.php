<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $modelContasareceber app\models\Contasareceber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contasareceber-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($modelContasareceber, 'idconta')->hiddenInput([$modelContasareceber->idconta])->label(false)?>

	<?= $form->field($modelContasareceber, 'dataHora')->widget(DateControl::classname(), [
		'type'=>DateControl::FORMAT_DATETIME,
		'ajaxConversion'=>false,
		'options' => [

		'pluginOptions' => [
		'autoclose' => true
		]
		],
		'displayFormat' => 'dd/MM/yyyy H:m ',
		'language'=>'pt',
		]); ?>

		<div class="form-group">
			<?= Html::submitButton($modelContasareceber->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $modelContasareceber->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
