<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Insumos */
/* @var $form yii\widgets\ActiveForm */
$action = Yii::$app->controller->action->id;

switch ($action) {
	/*case 'alterarprodutovenda':
	$idprodutoInsumo = 'idprodutoInsumo';
	$quantidade = 'quantidade';
	$unidade = 'unidade';
	break;
	
	case 'create':
	$idprodutoInsumo = 'idprodutoInsumo[]';
	$quantidade = 'quantidade[]';
	$unidade = 'unidade[]';
	break;*/
	default:
	$idprodutoInsumo = 'idprodutoInsumo[]';
	$quantidade = 'quantidade[]';
	$unidade = 'unidade[]';
	break;
}
$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Produto',
	]) . ' ' . $modelProdutoVenda->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['produtosvenda']];
$this->params['breadcrumbs'][] = ['label' =>'Produto '.$modelProdutoVenda->nome, 'url' => ['view', 'id' => $modelProdutoVenda->idProduto]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');

?>
<div class="insumos-form">

	<?php $form = ActiveForm::begin(); ?>




	<?= 
	$form->field($models[0], 'idprodutoVenda')->textInput(['value'=>$modelProdutoVenda->nome, 
		'disabled'=>true]);

		?>

		<hr>
		<?php 
		for ($i = 0 ; $i< count($models); $i++) {
			?>
			<div class "form-group field-insumos-idprodutoinsumo required" id="<?= 'inputinsumo' .$i ?>"> 
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
echo Html::activeLabel($models[$i], $idprodutoInsumo, ['class'=>'control-label']);
echo Select2::widget([
	'model'=>$models[$i],
	'name' =>'Insumos[idprodutoInsumo][]',
    'value' => $models[$i]->idprodutoInsumo, // initial value
    'data' => $insumos,
    
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
echo $form->field($models[$i],  $quantidade)->textInput([ 'type' => 'number', 
	'value'=>0, 'min'=>0, 'step'=>'0.1','id'=>'quantidade'.$i,'value' => Yii::$app->formatter->asDecimal($models[$i]->quantidade)]);

echo $form->field($models[$i], $unidade)->dropDownList(
	['kg'=> 'Kg', 'l'=>'Litros', 'unidade'=>'Unidade'],
	['prompt'=>'Selecione a unidade', 
	'options'=>[$models[$i]->unidade=>['Selected'=>true]]]); 
echo "<hr>";
?><input class="btn btn-danger" onclick="removeins(<?= $i?>)" type='button' value="Remover Insumo"> </div>
</br> <?php
}


?>	

<div class="table-responsive" id="input-dinamico">
	<?php

	$options = array();
	$opt = "<option value=\"\">Selecione um insumo</option>";
	array_push($options,$opt );
	foreach ($insumos as $k => $v) {
		$opt = "<option value=\"".$k."\">".$v."</option>";
		array_push($options,$opt );
	}
	$o = implode("", $options);

	

	$this->registerJs('var i = '.$i.';  console.log(\'i:\'+i);$("#btnadd").on("click",function(){'
		. '$("#input-dinamico").append(\'<div id="inputinsumo\'+i+\'" ><div class="form-group field-insumos-idprodutoinsumo required"><label class="control-label" for="insumos-idprodutoinsumo">Insumo</label><select required="true" id="idinsumo\'+i+\'" class="form-control" name="Insumos[idprodutoInsumo][]" >'.$o.'</select><div class="help-block"></div></div><div class="form-group field-insumos-quantidade required"><label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input required="true" type="number" id="quantidade\'+i+\'" class="form-control" name="Insumos[quantidade][]" value="0" min="0" step="0.1"><div class="help-block"></div></div><div class="form-group field-insumos-unidade required"><label class="control-label" for="insumos-unidade\'+i+\'">Unidade</label><select required="true" id="insumos-unidade\'+i+\'" class="form-control" name="Insumos[unidade][]"><option value="">Selecione a unidade</option><option value="kg">Kg</option><option value="l">Litros</option><option value="unidade">Unidade</option></select><div class="help-block"></div></div><input class="btn btn-danger" onclick="removeins(\'+i+\')" type="button" value="Remover Insumo"> <hr></div>\');'
		. '$("[name=\'Insumos[idprodutoInsumo][]\']").select2();i=i+1;console.log(\'add:\'+i);' 
		. '})');
$this->registerJs('$("#btnrem").on("click",function(){var input_insumo = \'inputinsumo\'+(i-1);$(\'#\'+input_insumo).empty();console.log(input_insumo);$("[name=\'idprodutoInsumo[]\']").remove();i = i-1;})');




?>			
</div>
<div class="form-group">
	<?= Html::submitButton($modelProdutoVenda->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => 'btn btn-success']) ?>
	<input class="btn btn-primary" type='button' id='btnadd' value="Adicionar mais insumos">
	<!-- <input class="btn btn-primary" type='button' id='btnrem' value="Remover Insumo"> -->


</div>

<?php ActiveForm::end(); ?>


<?=  Html::beginForm('/applanchonete/web/insumos/create','post',['id'=>'idd']) ?>
<div id="dynamicInput">
</br>

</div>
<?= Html::endForm() ?>
</div>
<script type="text/javascript">
function removeins(id){
	$('#inputinsumo'+id).empty();
}

</script>