<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\datecontrol\DateControl;
use app\models\Fornecedor;
/* @var $this yii\web\View */
/* @var $model app\models\Compra */
/* @var $form yii\widgets\ActiveForm */

$fornecedores=Fornecedor::find()->all();

use yii\helpers\ArrayHelper;

$listadefornecedores=ArrayHelper::map($fornecedores,'idFornecedor','nome');

?>

<div class="compra-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'datacompra')->widget(DateControl::classname(), [
		'type'=>DateControl::FORMAT_DATE,
		'ajaxConversion'=>false,
		'options' => [

		'pluginOptions' => [
		'autoclose' => true
		]
		],
		'displayFormat' => 'dd/MM/yyyy',
		'language'=>'pt',
		]); ?>

	<?= $form->field($model, 'totalcompra')->widget(MaskMoney::classname(), [
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]); ?>

		<?= $form->field($model, 'fornecedor_idFornecedor')->dropDownList($listadefornecedores, ['prompt'=>'Selecione o fornecedor']) ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
