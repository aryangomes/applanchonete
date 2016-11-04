<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Insumo */
/* @var $form yii\widgets\ActiveForm */
$action = Yii::$app->controller->action->id;

switch ($action) {
	case 'update':
	$idprodutoInsumo = 'idprodutoInsumo';
	$quantidade = 'quantidade';
	$unidade = 'unidade';
	$idinsumo = 'insumos-idprodutoinsumo';
	break;
	
	case 'create':
	$idprodutoInsumo = 'idprodutoInsumo[]';
	$quantidade = 'quantidade[]';
	$unidade = 'unidade[]';
	break;
	default:
	$idprodutoInsumo = 'idprodutoInsumo[]';
	$quantidade = 'quantidade[]';
	$unidade = 'unidade[]';
	$idinsumo = 'idinsumo0';
	break;
}



?>
<div class="insumos-form">

	<?php $form = ActiveForm::begin(); ?>



	<?= 
	$form->field($model, 'idprodutoVenda')->widget(Select2::classname(), [
		'data' => $produtosvenda,
		'disabled'=>($action == 'update') ? true : false,
		'options' => ['placeholder' => 'Selecione o produto de venda'],
		'pluginOptions' => [
		'allowClear'=>true,
		],
		]);

		?>

		<hr><div class="form-group field-insumos-idprodutoinsumo required">
		<?php 
		echo $form->field($model, $idprodutoInsumo)->widget(Select2::classname(), [
				//'name'=>'insumos[]',
			'data' => $insumos,

			'options' => ['placeholder' => 'Selecione o insumo',
			//'id'=>$idinsumo,
		//	'required'=>'required',
			],
			'pluginOptions' => [
			'allowClear'=>true,

			],
			]);
			?></div>
			<?php

			echo $form->field($model,  $quantidade)->textInput([ 'type' => 'number', 
				 'min'=>0, 'step'=>'0.1','id'=>'quantidade0']);

			echo $form->field($model, $unidade)->dropDownList(
				['kg'=> 'Kg', 'l'=>'Litros', 'unidade'=>'Unidade'],
				['prompt'=>'Selecione a unidade']); 

				?>	
				<input class="btn btn-danger" onclick="removeins(0)" type='button' value="Remover Insumo" >
				<hr>
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


					if (isset($action) && $action == 'cadastrarprodutovenda') {

						$this->registerJs('var i = 1; $("#btnadd").on("click",function(){'
							. '$("#input-dinamico").append(\'<div id="inputinsumo\'+i+\'" ><div class="form-group field-insumos-idprodutoinsumo required"><label class="control-label" for="insumos-idprodutoinsumo">Insumo</label><select id="insumos-idprodutoinsumo" class="form-control" name="Insumos[idprodutoInsumo][]" >'.$o.'</select><div class="help-block"></div></div><div class="form-group field-insumos-quantidade required"><label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input type="number" id="quantidade\'+i+\'" class="form-control" name="Insumos[quantidade][]" value="0" min="0" step="0.1"><div class="help-block"></div></div><div class="form-group field-insumos-unidade required"><label class="control-label" for="insumos-unidade\'+i+\'">Unidade</label><select id="insumos-unidade\'+i+\'" class="form-control" name="Insumos[unidade][]"><option value="">Selecione a unidade</option><option value="kg">Kg</option><option value="l">Litros</option><option value="unidade">Unidade</option></select><div class="help-block"></div><input class="btn btn-danger" onclick="removeins(\'+i+\')" type="button" value="Remover Insumo"></div><hr></div>\');'
							. '$("[name=\'Insumos[idprodutoInsumo][]\']").select2();i = i+1;' 
							. '})');

}


?>			
</div>
<div class="form-group">
	<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'),
		['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
			'title'=>$model->isNewRecord ? 'Clique para cadastrar um novo Insumo':
				'Clique para salvar os dados do Insumo']) ?>
	<?php if (isset($action) && $action == 'cadastrarprodutovenda') {
		?><input class="btn btn-primary" type='button' id='btnadd' value="Adicionar mais insumos">
		<?php } ?>
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