<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Insumos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insumos-form">

	<?php $form = ActiveForm::begin(); ?>



	<?= 
	$form->field($model, 'idprodutoVenda')->widget(Select2::classname(), [
		'data' => $produtosvenda,
		'options' => ['placeholder' => 'Selecione o produto de venda'],
		'pluginOptions' => [
		'allowClear'=>true,
		],
		]);

		?>

		<?= 
		$form->field($model, 'idprodutoInsumo')->widget(Select2::classname(), [
			'data' => $insumos,
			'options' => ['placeholder' => 'Selecione o insumo'],
			'pluginOptions' => [
			'allowClear'=>true,
			],
			]);

			?>

			<?= $form->field($model, 'quantidade')->textInput([ 
			'type' => 'number', 'value'=>0, 'min'=>0, 'step'=>'0.1']) ?>


			<?= $form->field($model, 'unidade')->dropDownList(
				['kg'=> 'Kg', 'l'=>'Litros', 'unidade'=>'Unidade'],
				['prompt'=>'Selecione a unidade']); ?>

				<div class="form-group">
					<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				</div>

				<?php ActiveForm::end(); ?>

			</div>
