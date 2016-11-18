<?php
/*
 * Formulário utilizado para criação/atualização de Produto,
 * seja ele, um Insumo ou Produto Venda
 *
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $modelProduto app\models\Produto */
/* @var $form yii\widgets\ActiveForm */
/* @var $action Yii::$app->controller->action->id */
/* @var $modelsInsumos app\models\Insumo[] */
/* @var $insumos yii\helpers\ArrayHelper de app\models\Produto */
/* @var $categorias yii\helpers\ArrayHelper de app\models\Categoria */
/* var $modelProdutoVenda app\models\Produto */
/* var $modelInsumo app\models\Insumo */

//Pega a ação do controlador
$action = Yii::$app->controller->action->id;
?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?php
/**
 * Verifica se a ação é de criar um produto
 * ou é uma ação de atualizar um Produto que é um Insumo.
 *
 * Essa última verificação é feita para mostrar somente
 * os campos que são de um Produto que é Insumo
 */
if ($action == 'create' || ($modelProduto->isInsumo && $action == 'update')) {
    ?>
    <div class="produto-form">


        <?= $form->field($modelProduto, 'nome')->textInput(['maxlength' => true]) ?>



        <?php
        echo $form->field($modelProduto, 'isInsumo')->dropDownList([1 => 'Sim', 0 => 'Não'], ['prompt' => 'Informe se o produto cadastrado é insumo']);
        ?>

        <?php
        /**
         * Verifica se há um Produto e se ele é não um Insumo
         *
         * Caso ele não seja um Insumo, conclui-se que é um Produto Venda,
         * logo o campo de quantidadeMinima(atributo de um Produto que é Insumo) é escondido do usuário
         */
        if (isset($modelProduto) && !$modelProduto->isInsumo) {
            $this->registerJs("$(\"[class~='field-produto-quantidademinima']\").hide(); ");
        }

        echo $form->field($modelProduto, 'quantidadeMinima')->textInput(['type' => 'number',
            'min' => '0',
            'step' => '0.01',
            'value' => isset($modelProduto->quantidadeMinima) ? $modelProduto->quantidadeMinima : 0]);
        ?>

        <?=
        $form->field($modelProduto, 'idCategoria')->widget(Select2::classname(), [
            'data' => $categorias,
            'options' => ['placeholder' => 'Seleciona a categoria'],
            'pluginOptions' => [
            ],
        ]);
        ?>

        <?php
        /**
         * Verifica se há um Produto e se ele é não um Insumo
         *
         * Caso ele não seja um Insumo, conclui-se que é um Produto Venda,
         * logo o campo de quantidadeEstoque(atributo de um Produto que é Insumo) é escondido do usuário
         */
        if (isset($modelProduto) && !$modelProduto->isInsumo) {
            $this->registerJs("$(\"[class~='field-produto-quantidadeestoque']\").hide(); ");
        }

        ?>


        <div id="form-insumos-produtovenda">
            <div class="<?= !$modelProduto->isInsumo ? "divborda" : '' ?>">
                <div class="insumos-form">

                    <div class="form-group field-insumos-idprodutoinsumo required">
                        <?php
                        /**
                         * Verifica se o Produto é um Produto Venda
                         *
                         * Caso ele seja, o campo de idprodutoInsumo(atributo de Insumo) é mostrado do usuário
                         *
                         * Produto Venda é composto por 1 ou mais Insumos
                         *
                         * idprodutoInsumo[], representa o array de idprodutoInsumo
                         */
                        echo (!$modelProduto->isInsumo) ? $form->field($modelInsumo, 'idprodutoInsumo[]')->widget(Select2::classname(), [

                            'data' => $insumos,
                            'options' => ['placeholder' => 'Selecione o insumo',
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]) : '';
                        ?>
                    </div>
                    <?php
                    /**
                     * Verifica se o Produto é um Produto Venda
                     *
                     * Caso ele seja, o campo de quantidade(atributo de Insumo) é mostrado do usuário
                     *
                     * Produto Venda é composto por 1 ou mais Insumos
                     *
                     * quantidade[], representa o array de quantidade
                     */
                    echo (!$modelProduto->isInsumo) ? $form->field($modelInsumo, 'quantidade[]')->textInput(['type' => 'number',
                        'min' => 0, 'step' => '0.1', 'id' => 'quantidade0',
                        'value' => Yii::$app->formatter->asDecimal($modelInsumo->quantidade)]) : '';


                    /**
                     * Verifica se o Produto é um Produto Venda
                     *
                     * Caso ele seja, o campo de unidade(atributo de Insumo) é mostrado do usuário
                     *
                     * Produto Venda é composto por 1 ou mais Insumos
                     *
                     * unidade[], representa o array de unidade
                     */
                    echo (!$modelProduto->isInsumo) ? $form->field($modelInsumo, 'unidade[]')->dropDownList(
                        ['kg' => 'Kg', 'l' => 'Litros', 'unidade' => 'Unidade'], ['prompt' => 'Selecione a unidade']) : '';
                    ?>
                    <?php
                    /**
                     * Verifica se o Produto é um Produto Venda
                     *
                     * Caso ele seja, a opção de adicionar mais insumos é mostrado do usuário
                     *
                     * Produto Venda é composto por 1 ou mais Insumos
                     *
                     */
                    if (!$modelProduto->isInsumo) {
                        ?>
                        <input class="btn btn-danger" onclick="removeins(0)" type="button" value="Remover Insumo"
                               title="Remover insumo desse Produto">
                    <?php } ?>


                </div>
            </div>
        </div>

        <div class="table-responsive" id="input-dinamico">
        </div>
    </div>
    <?php
    /**
     * Verifica se a ação é de atualizar um produto
     * e se esse Produto não é um Insumo, ou seja, é um Produto Venda.
     */
} elseif (!$modelProduto->isInsumo && $action == 'update') {
    ?>
    <div class="insumos-form">

        <?=
        $form->field($modelsInsumos[0], 'idprodutoVenda')->textInput(['value' => $modelProdutoVenda->nome,
            'disabled' => true]);
        ?>


        <?=
        $form->field($modelProduto, 'idCategoria')->widget(Select2::classname(), [
            'data' => $categorias,
            'options' => ['placeholder' => 'Seleciona a categoria'],
            'pluginOptions' => [
            ],
        ]);
        ?>

        <?php
        /**
         * Laço de repetição usado para mostrar todos os insumos do Produto Venda,
         * no caso de atualização de um Produto Venda
         *
         *
         * @var $i integer
         */
        for ($i = 0; $i < count($modelsInsumos); $i++) {
            ?>
            <div class
            "form-group field-insumos-idprodutoinsumo required" id="<?= 'inputinsumo' . $i ?>">
            <div class="divborda">
                <?php
                echo Html::activeLabel($modelsInsumos[$i], 'idprodutoInsumo[]', ['class' => 'control-label']);
                echo Select2::widget([
                    'model' => $modelsInsumos[$i],
                    'name' => 'Insumo[idprodutoInsumo][]',
                    'value' => $modelsInsumos[$i]->idprodutoInsumo,
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
                <div class="help-block-insumo<?= $i ?>">

                </div>
                <?php
                echo "</br>";
                echo $form->field($modelsInsumos[$i], 'quantidade[]')->textInput(['type' => 'number',
                    'value' => 0, 'min' => 0, 'step' => '0.1', 'id' => 'quantidade' . $i, 'value' => ($modelsInsumos[$i]->quantidade)]);

                echo $form->field($modelsInsumos[$i], 'unidade[]')->dropDownList(
                    ['kg' => 'Kg', 'l' => 'Litros', 'unidade' => 'Unidade'], ['prompt' => 'Selecione a unidade',
                    'options' => [$modelsInsumos[$i]->unidade => ['Selected' => true]]]);

                ?>
                <input class="btn btn-danger" onclick="removeins(<?= $i ?>)" type='button' value="Remover Insumo"
                       title="Remover insumo desse Produto" ></div>
            </br>
            <?php
        }
        ?>
    </div>
    <div class="table-responsive" id="input-dinamico">
        <?php
        /**
         * Registra o Javascript para remover um campo de cadastro de Insumo
         * em Produto Venda
         */
        $this->registerJs('$("#btnrem").on("click",function(){var input_insumo = \'inputinsumo\'+(i-1);$(\'#\'+input_insumo).empty();console.log(input_insumo);$("[name=\'idprodutoInsumo[]\']").remove();i = i-1;})');
        ?>
    </div>


    <?php
}
?>
    <?= $form->field($modelProduto, 'imageFile')->fileInput(['class' => 'form-control']) ?>
    <div class="form-group">
        <?= Html::submitButton($action == 'create' ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => 'btn btn-success',
            'title'=>$modelProduto->isNewRecord ? 'Clique para cadastrar um novo Produto':
                'Clique para salvar os dados do Produto']) ?>
        <?php
        if (!$modelProduto->isInsumo) {
            ?>
            <input class="btn btn-primary" type='button' id='btnaddinsumo' value="Adicionar mais insumos"
                   title="Adicionar mais um insumo a esse Produto">
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

                $("#form-insumos-produtovenda").show();

                $("#insumo-idprodutoinsumo").prop('disabled', '');
                $("#quantidade0").prop('disabled', '');
                $("#insumo-unidade").prop('disabled', '');
                $("#btcadastrar").hide();
                $("#btnaddinsumo").show();
            } else if (ins == 1) {
                $("#btcadastrar").show();
                $("[class~='field-produto-quantidademinima']").show();
                $("[class~='field-produto-quantidadeestoque']").show();

                $("#btnaddinsumo").hide();

                $("#insumo-idprodutoinsumo").prop('disabled', 'disabled');
                $("#quantidade0").prop('disabled', 'disabled');
                $("#insumo-unidade").prop('disabled', 'disabled');
                $("#form-insumos-produtovenda").hide();
            }
        });

        <?php
        if (isset($insumos)) {
            /**
             * Cria um array com as opções de Insumos cadastrados
             */
            $options = array();
            $opt = "<option value=\"\">Selecione um insumo</option>";
            array_push($options, $opt);
            foreach ($insumos as $k => $v) {
                $opt = "<option value=\"" . $k . "\">" . $v . "</option>";
                array_push($options, $opt);
            }
            $arrayOptions = implode("", $options);

            /**
             * Registra o Javascript para adicionar os campos de cadastro de Insumo em Produto Venda:
             * idprodutoinsumo,quantidade,unidade dinamicamente
             */
            $this->registerJs('var i = 1; $("#btnaddinsumo").on("click",function(){'
                . '$("#input-dinamico").append(\'<div id="inputinsumo\'+i+\'" >' .
                '<div class="divborda"><div class="form-group field-insumos-idprodutoinsumo required"><label class="control-label" for="insumos-idprodutoinsumo">' .
                'Insumo</label><select id="insumos-idprodutoinsumo" class="form-control" name="Insumo[idprodutoInsumo][]" >'
                . $arrayOptions . '</select><div class="help-block"></div></div><div class="form-group field-insumos-quantidade required">' .
                '<label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input type="number" id="quantidade\'+i+\'" ' .
                'class="form-control" name="Insumo[quantidade][]" value="0" min="0" step="0.1"><div class="help-block"></div></div>' .
                '<div class="form-group field-insumos-unidade required"><label class="control-label" for="insumos-unidade\'+i+\'">Unidade' .
                '</label><select id="insumos-unidade\'+i+\'" class="form-control" name="Insumo[unidade][]"><option value="">Selecione a unidade' .
                '</option><option value="kg">Kg</option><option value="l">Litros</option><option value="unidade">Unidade</option></select>' .
                '<div class="help-block"></div><input class="btn btn-danger" onclick="removeins(\'+i+\')" type="button" value="Remover Insumo"    title="Remover insumo desse Produto">' .
                '</div></div></div>\');'
                . '$("[name=\'Insumo[idprodutoInsumo][]\']").select2();i = i+1;'
                . '})');
        }
        ?>

        /**
         *
         * @param id
         * Remove um campo de Insumo
         */
        function removeins(id) {
            $('#inputinsumo' + id).empty();
        }


    </script>

<?php

if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>