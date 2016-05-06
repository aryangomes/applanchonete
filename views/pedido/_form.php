<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pedido-form">

	<?php $form = ActiveForm::begin(); ?>

	<?php /* $form->field($model, 'totalPedido')->widget(MaskMoney::classname(), [
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]);*/ ?>

		<?= $form->field($model, 'idSituacaoAtual')->dropDownList($situacaopedido, ['prompt'=>'Selecione a situação do pedido']) ?>


		<?php 
		if (Yii::$app->controller->action->id == 'update') {
			echo $form->field($tipoPagamento, 'idTipoPagamento')->dropDownList($tiposPagamento, ['prompt'=>'Selecione a forma de  pagamento']);
		}
		?>


		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
