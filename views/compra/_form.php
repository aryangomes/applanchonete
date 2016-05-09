<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use kartik\money\MaskMoney;
/* @var $this yii\web\View */
/* @var $model app\models\Compra */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="compra-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //$form->field($model, 'idconta')->textInput() ?>

    <?= $form->field($model, 'dataCompra')->widget(DateControl::classname(), [
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

<?= 
	$form->field($compraProduto, 'idProduto[]')->widget(Select2::classname(), [
		'data' => $produtos,
		'options' => ['placeholder' => 'Selecione o produto'],
		'pluginOptions' => [
		'allowClear'=>true,
		],
		]);

		?>

		<?= 
	$form->field($compraProduto, 'quantidade[]')->textInput([ 'type' => 'number', 'value'=>0]); 

		?>

		<?= 
	$form->field($compraProduto, 'valorCompra[]')->widget(MaskMoney::classname(), [
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]);

		?>

		<div class="table-responsive" id="input-dinamico">

		</div>

		<?php


					$options = array();
					$opt = "<option value=\"\">Selecione um produto</option>";
					array_push($options,$opt );
					foreach ($produtos as $k => $v) {
						$opt = "<option value=\"".$k."\">".$v."</option>";
						array_push($options,$opt );
					}
					$o = implode("", $options);

$this->registerJs('var i = 1; $("#btnadprodutocompra").on("click",function(){'
							. '$("#input-dinamico").append(\'<div id="inputinsumo\'+i+\'" ><div class="form-group field-insumos-idprodutoinsumo required"><label class="control-label" for="insumos-idprodutoinsumo">Produto</label><select id="compraproduto-idproduto" class="form-control" name="Compraproduto[idProduto][]" >'.$o.'</select><div class="help-block"></div></div><div class="form-group field-insumos-quantidade required"><label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input type="number" id="quantidade\'+i+\'" class="form-control" name="Compraproduto[quantidade][]" value="1" min="0" step="1"><div class="help-block"></div></div><div class="form-group field-compraproduto-valorcompra required has-success"><label class="control-label" for="compraproduto-valorcompra\'+i+\'">Valor da Compra</label><input type="text" id="compraproduto-valorcompra-disp" class="form-control" name="compraproduto-valorcompra-disp[]"><input type="hidden" id="compraproduto-valorcompra\'+i+\'" name="Compraproduto[valorCompra][]" data-krajee-maskmoney="maskMoney_17eeef61" value="0"><div class="help-block"></div></div><input class="btn btn-danger" onclick="removeins(\'+i+\')" type="button" value="Remover Produto"></div><hr></div>\');'
							. '$("[name=\'Compraproduto[idProduto][]\']").select2();$("[name=\'compraproduto-valorcompra-disp[]\']").maskMoney({prefix:\'R$: \'});i = i+1;' 
							. '})');

		?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <input class="btn btn-primary" type='button' id='btnadprodutocompra' value="Adicionar Produto">
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
function removeins(id){
	$('#inputinsumo'+id).empty();
}
</script>