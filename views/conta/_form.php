<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;

use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model app\models\Conta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conta-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'valor')->widget(MaskMoney::classname(), [
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]);  ?>

	<?= $form->field($model, 'descricao')->textarea(
	['rows' => 6, 'placeholder'=>'Digite a descrição da conta']) ?>

	<?= $form->field($model, 'tipoConta')->dropDownList(
		['contasapagar'=>'Conta a pagar','contasareceber'=>'Conta a receber'],
		['prompt'=>'Selecione o tipo de conta']) ?>

	<?= $form->field($modelContaapagar, 'situacaoPagamento')->dropDownList(
	[1=>'Paga',0=>'Não paga'],['prompt'=>'Seleciona a situação do pagamento']) ?>

	<?= $form->field($modelContaapagar, 'dataVencimento')->widget(DateControl::classname(), [
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

	<?php 
	$this->registerJs('
		$("[class=\'form-group field-contasapagar-datavencimento\']").hide();
		$("[class=\'form-group field-contasapagar-situacaopagamento required\']").hide();
		$("[class=\'form-group field-contasareceber-datahora\']").hide();
		$("#conta-tipoconta").change(function(){
			var tipo = $("#conta-tipoconta").val();
			console.log(tipo);
			if (tipo == \'contasapagar\') {
				$("[class=\'form-group field-contasapagar-datavencimento\']").show();
				$("[class=\'form-group field-contasapagar-situacaopagamento required\']").show();
				$("[class=\'form-group field-contasapagar-datavencimento\']").prop(\'disabled\', false);
				$("#contasapagar-situacaopagamento").prop(\'disabled\', false);
				$("[class=\'form-group field-contasareceber-datahora\']").hide();
				$("[class=\'form-group field-contasareceber-datahora\']").prop(\'disabled\', true);

			}else if (tipo == \'contasareceber\') {
				$("[class=\'form-group field-contasapagar-datavencimento\']").hide();
				$("[class=\'form-group field-contasapagar-situacaopagamento required\']").hide();
				$("[class=\'form-group field-contasapagar-datavencimento\']").prop(\'disabled\', true);
				$("#contasapagar-situacaopagamento").prop(\'disabled\', true);
				$("[class=\'form-group field-contasareceber-datahora\']").show();
				$("[class=\'form-group field-contasareceber-datahora\']").prop(\'disabled\', false);

			}
		});'); 

		?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
