<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model app\models\Caixa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="caixa-form">

	<?php $form = ActiveForm::begin(); ?>



	<?= $form->field($model, 'valorapurado')->widget(MaskMoney::classname(), [
		'options'=>[
		'value'=>$model->valorapurado],
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]);  ?>

	<?= $form->field($model, 'valoremcaixa')->widget(MaskMoney::classname(), [
		'options'=>[
		'value'=>$model->valoremcaixa],
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]);  ?>

	<?= $form->field($model, 'valorlucro')->widget(MaskMoney::classname(), [
		'options'=>[
		'value'=>$model->valorlucro],
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]);  ?>

		<?php 
			$model->dataabertura = date('d/m/Y');
			
		?>
		
		
		 <?= $form->field($model, 'dataabertura')->widget(DateControl::classname(), [
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
		

		<!-- $form->field($model, 'user_id' )->hiddenInput(['value'=>Yii::$app->user->getId()])->label(false); -->


		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
