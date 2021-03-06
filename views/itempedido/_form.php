<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Itempedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="itempedido-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'idPedido')->widget(Select2::classname(), [
		'data' => $pedidos,
		'options' => ['placeholder' => 'Seleciona o Pedido'],
		'pluginOptions' => [
           // 'allowClear' => true
		],
		]);
		?>

		<?= $form->field($model, 'idProduto')->widget(Select2::classname(), [
			'data' => $produtosvenda,
			'options' => ['placeholder' => 'Seleciona o Produto Venda'],
			'pluginOptions' => [
           // 'allowClear' => true
			],
			]);
			?>

			<?= $form->field($model, 'quantidade')->textInput([ 'type' => 'number', 
			'min'=>1, 'step'=>'1', 'placeholder'=>'Digite a quantidade']) ?>

			<?= $form->field($model, 'total')->hiddenInput(['value' => 0])->label(false) ?>

			<div class="form-group">
				<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
