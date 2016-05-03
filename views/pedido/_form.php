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

	<?= $form->field($model, 'totalPedido')->widget(MaskMoney::classname(), [
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]); ?>

		<?= $form->field($model, 'idSituacaoAtual')->dropDownList($situacaopedido, ['prompt'=>'Selecione a situação do pedido']) ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
