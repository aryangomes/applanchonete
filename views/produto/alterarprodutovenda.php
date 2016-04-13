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
echo Html::activeLabel($models[$i], $idprodutoInsumo);
echo Select2::widget([
	'model'=>$models[$i],
	'name' => $idprodutoInsumo,
    'value' => $models[$i]->idprodutoInsumo, // initial value
    'data' => $insumos,
    'options' => ['placeholder' => 'Selecione o insumo',
    'id'=>'idinsumo'.$i,

    ],
    'pluginOptions' => [
    'allowClear'=>true,
    ],
    ]);
echo "</br>";
echo $form->field($models[$i],  $quantidade)->textInput([ 'type' => 'number', 
	'value'=>0, 'min'=>0, 'step'=>'0.1','id'=>'quantidade'.$i,'value' => Yii::$app->formatter->asDecimal($models[$i]->quantidade)]);

echo $form->field($models[$i], $unidade)->dropDownList(
	['kg'=> 'Kg', 'l'=>'Litros', 'unidade'=>'Unidade'],
	['prompt'=>'Selecione a unidade', 
	'options'=>[$models[$i]->unidade=>['Selected'=>true]]]); 
echo "<hr>";
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



	$this->registerJs('var i = '.$i.'; $("#btnadd").on("click",function(){'
		. '$("#input-dinamico").append(\'<div class="form-group field-insumos-idprodutoinsumo required"><label class="control-label" for="insumos-idprodutoinsumo">Insumo</label><select id="idinsumo\'+i+\'" class="form-control" name="idprodutoInsumo[]" >'.$o.'</select><div class="help-block"></div></div>\');'
		. '$("#input-dinamico").append(\'<div class="form-group field-insumos-quantidade required"><label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input type="number" id="quantidade\'+i+\'" class="form-control" name="Insumos[quantidade][]" value="0" min="0" step="0.1"><div class="help-block"></div></div>\');'
		. '$("#input-dinamico").append(\'<div class="form-group field-insumos-unidade required"><label class="control-label" for="insumos-unidade\'+i+\'">Unidade</label><select id="insumos-unidade\'+i+\'" class="form-control" name="Insumos[unidade][]"><option value="">Selecione a unidade</option><option value="kg">Kg</option><option value="l">Litros</option><option value="unidade">Unidade</option></select><div class="help-block"></div></div>\');'
		. '$("#input-dinamico").append(\'<hr>\');'
		. '$("[name=\'idprodutoInsumo[]\']").select2();;' 
		. '})');




		?>			
	</div>
	<div class="form-group">
		<?= Html::submitButton($modelProdutoVenda->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $modelProdutoVenda->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		<input class="btn btn-primary" type='button' id='btnadd' value="Adicionar mais insumos">

		
	</div>

	<?php ActiveForm::end(); ?>


	<?=  Html::beginForm('/applanchonete/web/insumos/create','post',['id'=>'idd']) ?>
	<div id="dynamicInput">
	</br>

</div>
<?= Html::endForm() ?>
</div>
