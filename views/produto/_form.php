<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Produto */
/* @var $form yii\widgets\ActiveForm */
$action = Yii::$app->controller->action->id;


        $idprodutoInsumo = 'idprodutoInsumo[]';
        $quantidade = 'quantidade[]';
        $unidade = 'unidade[]';
        $idinsumo = 'idinsumo0';


?>
<?php $form = ActiveForm::begin(); ?>
<?php
if($action == 'create' || ($model->isInsumo && $action=='update')) {


    ?>
    <div class="produto-form">



        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        <?php
        if (isset($model) && $model->isInsumo) {
            $this->registerJs("$(\"[class~='field-produto-valorvenda']\").hide(); ");
        }


        echo $form->field($model, 'valorVenda')->widget(MaskMoney::classname(), [
            'pluginOptions' => [
                'prefix' => 'R$ ',

                'allowNegative' => false,
            ]
        ]);
        ?>

        <?php
        //Usando o dropDownList pois o SwitchInput está bugado
        echo $form->field($model, 'isInsumo')->dropDownList([1 => 'Sim', 0 => 'Não'], ['prompt' => 'Informe se o produto cadastrado é insumo']);
        ?>

        <?php

        if (isset($model) && !$model->isInsumo) {
            $this->registerJs("$(\"[class~='field-produto-quantidademinima']\").hide(); ");

        }

        echo $form->field($model, 'quantidadeMinima')->textInput(['type' => 'number', 'value' => 0]);

        ?>

        <?=
        $form->field($model, 'idCategoria')->widget(Select2::classname(), [
            'data' => $categorias,
            'options' => ['placeholder' => 'Seleciona a categoria'],
            'pluginOptions' => [

            ],
        ]);
        ?>

        <?php
        if (isset($model) && !$model->isInsumo) {
            $this->registerJs("$(\"[class~='field-produto-quantidadeestoque']\").hide(); ");

        }
        echo $form->field($model, 'quantidadeEstoque')->textInput(['type' => 'number', 'value' => 0]);

        ?>





        <div id="form-insumos-produtovenda">
            <div class="insumos-form">


                <hr>
                <div class="form-group field-insumos-idprodutoinsumo required">
                    <?php
                    echo (!$model->isInsumo) ?  $form->field($insumo, $idprodutoInsumo)->widget(Select2::classname(), [
                        //'name'=>'insumos[]',
                        'data' => $insumos,

                        'options' => ['placeholder' => 'Selecione o insumo',

                        ],
                        'pluginOptions' => [
                            'allowClear' => true,

                        ],
                    ]) : '';
                    ?></div>
                <?php

                echo (!$model->isInsumo) ?  $form->field($insumo, $quantidade)->textInput(['type' => 'number',
                    'value' => 0, 'min' => 0, 'step' => '0.1', 'id' => 'quantidade0',
                    'value' => Yii::$app->formatter->asDecimal($insumo->quantidade)]) : '';

                echo (!$model->isInsumo) ?  $form->field($insumo, $unidade)->dropDownList(
                    ['kg' => 'Kg', 'l' => 'Litros', 'unidade' => 'Unidade'],
                    ['prompt' => 'Selecione a unidade']) : '';

               
                ?>
                <?php if (!$model->isInsumo) {?>
                <input class="btn btn-danger" onclick="removeins(0)" type="button" value="Remover Insumo">
                <?php } ?>
                <hr>
                <div class="table-responsive" id="input-dinamico">
                </div>




            </div>
        </div>
    </div>
    <?php

}elseif(!$model->isInsumo && $action == 'update'){
    
    ?>
    <div class="insumos-form">

    <?=
    $form->field($models[0], 'idprodutoVenda')->textInput(['value' => $modelProdutoVenda->nome,
        'disabled' => true]);

    ?>


    <?php
    echo  (!$model->isInsumo) ? $form->field($model, 'valorVenda')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            'prefix' => 'R$ ',

            'allowNegative' => false,
        ]
    ]): '';
    ?>

    <?=
    $form->field($model, 'idCategoria')->widget(Select2::classname(), [
        'data' => $categorias,
        'options' => ['placeholder' => 'Seleciona a categoria'],
        'pluginOptions' => [

        ],
    ]);
    ?>
    <hr>
    <?php
    for ($i = 0;
         $i < count($models);
         $i++) {

        ?>
        <div class
        "form-group field-insumos-idprodutoinsumo required" id="<?= 'inputinsumo' . $i ?>">
        <?php

        echo Html::activeLabel($models[$i], $idprodutoInsumo, ['class' => 'control-label']);
        echo Select2::widget([
            'model' => $models[$i],
            'name' => 'Insumo[idprodutoInsumo][]',
            'value' => $models[$i]->idprodutoInsumo, // initial value
            'data' => $insumos,

            'options' => ['placeholder' => 'Selecione o insumo',
                'id' => 'idinsumo' . $i,

            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
            'pluginEvents' => [
                "change" => "function() {
    	var s = $(\"#idinsumo" . $i . "\").val();
    	console.log(s); 
    	if (s == \"\" || s == null) {
    		$(\".help-block-insumo" . $i . "\").append('</br><div class=\"alert alert-danger\">\"Insumo\" não pode ficar em branco.</div>');
    		//alert('Escolha um insumo ou remova-o');
    	}else{
    		$(\".help-block-insumo" . $i . "\").remove();
    	}
    }",
            ],
        ]);
        ?>
    <div class="help-block-insumo<?= $i ?>"></div><?php
        echo "</br>";
        echo $form->field($models[$i], $quantidade)->textInput(['type' => 'number',
            'value' => 0, 'min' => 0, 'step' => '0.1', 'id' => 'quantidade' . $i, 'value' => ($models[$i]->quantidade)]);

        echo $form->field($models[$i], $unidade)->dropDownList(
            ['kg' => 'Kg', 'l' => 'Litros', 'unidade' => 'Unidade'],
            ['prompt' => 'Selecione a unidade',
                'options' => [$models[$i]->unidade => ['Selected' => true]]]);
        echo "<hr>";
        ?><input class="btn btn-danger" onclick="removeins(<?= $i ?>)" type='button' value="Remover Insumo"></div>
        </br> <?php
    }


    ?>

    <div class="table-responsive" id="input-dinamico">
        <?php

        $options = array();
        $opt = "<option value=\"\">Selecione um insumo</option>";
        array_push($options, $opt);
        foreach ($insumos as $k => $v) {
            $opt = "<option value=\"" . $k . "\">" . $v . "</option>";
            array_push($options, $opt);
        }
        $o = implode("", $options);



        $this->registerJs('$("#btnrem").on("click",function(){var input_insumo = \'inputinsumo\'+(i-1);$(\'#\'+input_insumo).empty();console.log(input_insumo);$("[name=\'idprodutoInsumo[]\']").remove();i = i-1;})');


        ?>
    </div>



<?php
}


?>
<div class="form-group">
    <?= Html::submitButton($action=='create' ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => 'btn btn-success']) ?>
    <?php
    if (!$model->isInsumo) {
        ?>
        <input class="btn btn-primary" type='button' id='btnaddinsumo' value="Adicionar mais insumos">
        <?php
    }
    ?>

</div>

<?php ActiveForm::end(); ?>
    <script>
        $(document).ready(function () {
            $("#form-insumos-produtovenda").hide();
            $("#btnaddinsumo").hide();
        });


        $("[name='Produto[isInsumo]']").change(function () {
            var ins = $("[name='Produto[isInsumo]']").val();
            console.log(ins);
            if (ins == 0) {
                $("[class~='field-produto-quantidademinima']").hide();
                $("[class~='field-produto-quantidadeestoque']").hide();
                $("[class~='field-produto-valorvenda']").show();
                $("#form-insumos-produtovenda").show();
                $("#produto-valorvenda-disp").prop('disabled', '');
                $("#insumo-idprodutoinsumo").prop('disabled', '');
                $("#quantidade0").prop('disabled', '');
                $("#insumo-unidade").prop('disabled', '');
                $("#btcadastrar").hide();
                $("#btnaddinsumo").show();
            } else if (ins == 1) {
                $("#btcadastrar").show();
                $("[class~='field-produto-quantidademinima']").show();
                $("[class~='field-produto-quantidadeestoque']").show();
                $("[class~='field-produto-valorvenda']").hide();
                $("#btnaddinsumo").hide();
                $("#produto-valorvenda-disp").prop('disabled', 'disabled');
                $("#insumo-idprodutoinsumo").prop('disabled', 'disabled');
                $("#quantidade0").prop('disabled', 'disabled');
                $("#insumo-unidade").prop('disabled', 'disabled');
                $("#form-insumos-produtovenda").hide();
            }
        });

        <?php
        if(isset($insumos)) {
            $options = array();
            $opt = "<option value=\"\">Selecione um insumo</option>";
            array_push($options, $opt);
            foreach ($insumos as $k => $v) {
                $opt = "<option value=\"" . $k . "\">" . $v . "</option>";
                array_push($options, $opt);
            }
            $o = implode("", $options);
            $this->registerJs('var i = 1; $("#btnaddinsumo").on("click",function(){'
                . '$("#input-dinamico").append(\'<div id="inputinsumo\'+i+\'" ><div class="form-group field-insumos-idprodutoinsumo required"><label class="control-label" for="insumos-idprodutoinsumo">Insumo</label><select id="insumos-idprodutoinsumo" class="form-control" name="Insumo[idprodutoInsumo][]" >' . $o . '</select><div class="help-block"></div></div><div class="form-group field-insumos-quantidade required"><label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input type="number" id="quantidade\'+i+\'" class="form-control" name="Insumo[quantidade][]" value="0" min="0" step="0.1"><div class="help-block"></div></div><div class="form-group field-insumos-unidade required"><label class="control-label" for="insumos-unidade\'+i+\'">Unidade</label><select id="insumos-unidade\'+i+\'" class="form-control" name="Insumo[unidade][]"><option value="">Selecione a unidade</option><option value="kg">Kg</option><option value="l">Litros</option><option value="unidade">Unidade</option></select><div class="help-block"></div><input class="btn btn-danger" onclick="removeins(\'+i+\')" type="button" value="Remover Insumo"></div><hr></div>\');'
                . '$("[name=\'Insumo[idprodutoInsumo][]\']").select2();i = i+1;'
                . '})');
        }
        ?>


        function removeins(id) {
            $('#inputinsumo' + id).empty();
        }


    </script>