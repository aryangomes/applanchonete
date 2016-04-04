<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
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
		<?php 
		for ($i=0; $i < $numeroinputs ; $i++) { 


			echo $form->field($model, 'idprodutoInsumo[]')->widget(Select2::classname(), [
				//'name'=>'insumos[]',
				'data' => $insumos,
				'options' => ['placeholder' => 'Selecione o insumo',
				'id'=>'idinsumo'.$i,
				],
				'pluginOptions' => [
				'allowClear'=>true,

				],
				]);



			echo $form->field($model, 'quantidade[]')->textInput([ 'type' => 'number', 
				'value'=>0, 'min'=>0, 'step'=>'0.1','id'=>'quantidade'.$i,]);

			echo $form->field($model, 'unidade[]')->dropDownList(
				['kg'=> 'Kg', 'l'=>'Litros', 'unidade'=>'Unidade'],
				['prompt'=>'Selecione a unidade']); 
		}	
		?>	




		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>


		<?=  Html::beginForm('/applanchonete/web/insumos/create','post',['id'=>'idd']) ?>
		<div id="dynamicInput">
		</br>

		<input type="number" id="numeroinputs" class="form-control" name="numeroinputs" value="1" min="0" step="1">
		<?= Html::submitButton( Yii::t('app', 'Mais insumos'), ['class' =>'btn btn-primary']) ?>
	</div>
	<?= Html::endForm() ?>
</div>
