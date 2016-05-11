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

<?php if (Yii::$app->controller->action->id == 'create') {
	
 ?>
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
	$form->field($compraProduto, 'quantidade[]')->textInput([ 'type' => 'number', 'value'=>1,'min'=>0]); 

		?>

		<?= 
	$form->field($compraProduto, 'valorCompra[]')->widget(MaskMoney::classname(), [
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]);

		?>
<?php }
else{
	
	echo $form->field($model, 'dataCompra')->widget(DateControl::classname(), [
			'type'=>DateControl::FORMAT_DATE,
			'ajaxConversion'=>false,
			'options' => [
			
			'pluginOptions' => [
			'autoclose' => true
			]
			],
			'displayFormat' => 'dd/MM/yyyy',
			'language'=>'pt',
			]);
	for ($i=0; $i < count($produtosDaCompras); $i++) { 
	
?><div class "form-group field-insumos-idprodutoinsumo required" id="<?= 'inputinsumo' .$i ?>"> 
				<?php
			/*echo $form->field($models[$i], $idprodutoInsumo)->widget(Select2::classname(), [
				//'name'=>'insumos[]',
				'data' => $insumos,
				'value'=>[77777777777777777],
				'options' => ['placeholder' => 'Selecione o insumo',
				'id'=>'idinsumo'.$i,

				],
				'pluginOptions' => [
				'allowClear'=>true,

				],
				]);*/
echo Html::activeLabel($produtosDaCompras[$i], 'idProduto', ['class'=>'control-label']);
echo Select2::widget([
	'model'=>$produtosDaCompras[$i],
	'name' =>'Compraproduto[idProduto][]',
    'value' => $produtosDaCompras[$i]->idProduto, // initial value
    'data' => $produtos,
    
    'options' => ['placeholder' => 'Selecione o insumo',
    'id'=>'idinsumo'.$i,

    ],
    'pluginOptions' => [
    'allowClear'=>true,
    ],
    'pluginEvents'=>[
    "change" => "function() {
    	var s = $(\"#idinsumo".$i."\").val();
    	console.log(s); 
    	if (s == \"\" || s == null) {
    		$(\".help-block-insumo".$i."\").append('</br><div class=\"alert alert-danger\">\"Insumo\" não pode ficar em branco.</div>');
    		//alert('Escolha um insumo ou remova-o');
    	}else{
    		$(\".help-block-insumo".$i."\").remove();
    	}
    }",
    ],
    ]);
?><div class="help-block-insumo<?= $i?>"> </div><?php
echo "</br>";

echo $form->field($compraProduto, 'quantidade[]')->textInput([ 'type' => 'number', 'value'=>$produtosDaCompras[$i]->quantidade,'min'=>0]); 

echo $form->field($compraProduto, 'valorCompra[]')->widget(MaskMoney::classname(), [
	'options'=>[
	'id'=>'valorCompra'.$produtosDaCompras[$i]->idProduto,
	'value'=>$produtosDaCompras[$i]->valorCompra,
	],
		'pluginOptions' => [
		'prefix' => 'R$ ',
		
		'allowNegative' => false,
		]
		]);
?>
<input class="btn btn-danger" onclick="removeins(<?= $i?>)" type='button' value="Remover Insumo"> </div></br><?php 
	}
}

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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <input class="btn btn-primary" type='button' id='btnadprodutocompra' value="Adicionar Produto">
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
function removeins(id){
	$('#inputinsumo'+id).empty();
}
</script>