<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model app\models\Contasareceber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contasareceber-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'idconta')->hiddenInput([$model->idconta])->label(false)?>

	<?= $form->field($model, 'dataHora')->widget(DateControl::classname(), [
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
			<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
