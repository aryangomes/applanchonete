<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
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

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
