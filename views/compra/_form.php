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
            'type' => DateControl::FORMAT_DATE,
            'ajaxConversion' => false,
            'options' => [

                'pluginOptions' => [
                    'autoclose' => true
                ]
            ],
            'displayFormat' => 'dd/MM/yyyy',
            'language' => 'pt',
        ]); ?>


        <div class="divborda">
            <div class="row">
                <div class="col-md-6">

                    <?=
                    $form->field($compraProduto, 'idProduto[]')->widget(Select2::classname(), [
                        'data' => $produtos,
                        'options' => ['placeholder' => 'Selecione o produto',
                            'onChange' => 'mudarFoto(this)'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);

                    ?>

                </div>
                <div class="col-md-6">
                    Imagem
                    <img width="200" src="" class="img-responsive">
                </div>
            </div>


            <?=
            $form->field($compraProduto, 'quantidade[]')->textInput(['type' => 'number', 'value' => 1, 'min' => 0]);

            ?>

            <?=
            $form->field($compraProduto, 'valorCompra[]')->widget(MaskMoney::classname(), [
                'pluginOptions' => [
                    'prefix' => 'R$ ',

                    'allowNegative' => false,
                ]
            ]);


            $options = array();
            $opt = "<option value=\"\">Selecione um produto</option>";
            array_push($options, $opt);
            foreach ($produtos as $k => $v) {
                $opt = "<option value=\"" . $k . "\">" . $v . "</option>";
                array_push($options, $opt);
            }
            $o = implode("", $options);

            $this->registerJs('var i = 1; $("#btnadprodutocompra").on("click",function(){'
                . '$("#input-dinamico").append(\'<div class="divborda" id="inputinsumo\'+i+\'" ><div class="form-group field-insumos-idprodutoinsumo required"><div class="row"><div class="col-md-6"><label class="control-label" for="insumos-idprodutoinsumo">Produto</label><select onChange="mudarFoto(this)" id="compraproduto-idproduto" class="form-control" name="Compraproduto[idProduto][]" >' . $o . '</select><div class="help-block"></div></div><div class="col-md-6">Imagem<img width="200" src="" class="img-responsive"></div></div></div><div class="form-group field-insumos-quantidade required"><label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input type="number" id="quantidade\'+i+\'" class="form-control" name="Compraproduto[quantidade][]" value="1" min="0" step="1"><div class="help-block"></div></div><div class="form-group field-compraproduto-valorcompra required has-success"><label class="control-label" for="compraproduto-valorcompra\'+i+\'">Valor da Compra(R$)</label><input type="number" min="0" step="0.01" value="0" id="compraproduto-valorcompra-disp" class="form-control" name="compraproduto-valorcompra-disp[]"><input type="hidden" id="compraproduto-valorcompra\'+i+\'" name="Compraproduto[valorCompra][]" data-krajee-maskmoney="maskMoney_17eeef61" value="0"><div class="help-block"></div></div><input class="btn btn-danger" onclick="removeins(\'+i+\')" type="button" value="Remover Produto"></div><hr></div>\');'
                . '$("[name=\'Compraproduto[idProduto][]\']").select2();/*$("[name=\'compraproduto-valorcompra-disp[]\']").maskMoney({prefix:\'R$: \'})*/;i = i+1;'
                . '})');

            ?>
        </div>
    <?php } else {

        echo $form->field($model, 'dataCompra')->widget(DateControl::classname(), [
            'type' => DateControl::FORMAT_DATE,
            'ajaxConversion' => false,
            'options' => [

                'pluginOptions' => [
                    'autoclose' => true
                ]
            ],
            'displayFormat' => 'dd/MM/yyyy',
            'language' => 'pt',
        ]);

        $options = array();
        $opt = "<option value=\"\">Selecione um produto</option>";
        array_push($options, $opt);
        foreach ($produtos as $k => $v) {
            $opt = "<option value=\"" . $k . "\">" . $v . "</option>";
            array_push($options, $opt);
        }
        $o = implode("", $options);

        $this->registerJs('var i = ' . count($produtosDaCompras) . '; $("#btnadprodutocompra").on("click",function(){'
            . '$("#input-dinamico").append(\'<div class="divborda" id="inputinsumo\'+i+\'" ><div class="form-group field-insumos-idprodutoinsumo required"><div class="row"><div class="col-md-6"><label class="control-label" for="insumos-idprodutoinsumo">Produto</label><select onChange="mudarFoto(this)" id="compraproduto-idproduto" class="form-control" name="Compraproduto[idProduto][]" >' . $o . '</select><div class="help-block"></div></div><div class="col-md-6">Imagem<img width="200" src="" class="img-responsive"></div></div></div><div class="form-group field-insumos-quantidade required"><label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input type="number" id="quantidade\'+i+\'" class="form-control" name="Compraproduto[quantidade][]" value="1" min="0" step="1"><div class="help-block"></div></div><div class="form-group field-compraproduto-valorcompra required has-success"><label class="control-label" for="compraproduto-valorcompra\'+i+\'">Valor da Compra(R$)</label><input type="number" min="0" step="0.01" value="0" id="compraproduto-valorcompra-disp" class="form-control" name="compraproduto-valorcompra-disp[]"><input type="hidden" id="compraproduto-valorcompra\'+i+\'" name="Compraproduto[valorCompra][]" data-krajee-maskmoney="maskMoney_17eeef61" value="0"><div class="help-block"></div></div><input class="btn btn-danger" onclick="removeins(\'+i+\')" type="button" value="Remover Produto"></div><hr></div>\');'
            . '$("[name=\'Compraproduto[idProduto][]\']").select2();/*$("[name=\'compraproduto-valorcompra-disp[]\']").maskMoney({prefix:\'R$: \'})*/;i = i+1;'
            . '})');

        for ($i = 0; $i < count($produtosDaCompras); $i++) {

            ?>


            <div class="form-group field-insumos-idprodutoinsumo required divborda" id="<?= 'inputinsumo' . $i ?>">
                <div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php

                            echo Html::activeLabel($produtosDaCompras[$i], 'idProduto', ['class' => 'control-label']);
                            echo Select2::widget([
                                'model' => $produtosDaCompras[$i],
                                'name' => 'Compraproduto[idProduto][]',
                                'value' => $produtosDaCompras[$i]->idProduto, // initial value
                                'data' => $produtos,

                                'options' => ['placeholder' => 'Selecione o insumo',
                                    'id' => 'idinsumo' . $i,
                                    'onChange' => 'mudarFoto(this)',

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
                        </div>
                        <div class="col-md-6">
                            Imagem
                            <img width="200" src="<?=
                            ($produtosDaCompras[$i]->produto->foto) ?
                                'data:image/jpeg;base64,' . base64_encode($produtosDaCompras[$i]->produto->foto) :
                                '../imgs/semfoto.jpg' ?>" class="img-responsive">
                        </div>
                    </div>
                </div>
                <div class="help-block-insumo<?= $i ?>"></div><?php
                echo "</br>";

                echo $form->field($compraProduto, 'quantidade[]')->textInput(['type' => 'number', 'value' => $produtosDaCompras[$i]->quantidade, 'min' => 0]);


                $this->registerJsFile(\Yii::getAlias('@web') . "/assets/f39098af/js/jquery.maskMoney.js",
                    ['depends' => [\yii\web\JqueryAsset::className()]]);

                ?>
                <p>
                    <label>Valor da Compra(R$)</label>
                    <input type="number" min="0" step="0.01" id="compraproduto-valorcompra-disp"
                           value="<?= $produtosDaCompras[$i]->valorCompra ?>" class="form-control"
                           name="compraproduto-valorcompra-disp[]">
                </p>
                <input class="btn btn-danger" onclick="removeins(<?= $i ?>)" type='button'
                       value="Remover Produto da Compra">
            </div>
            </br><?php
        }
    }

    ?>
    <div class="table-responsive" id="input-dinamico">

    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Cadastrar a Compra')
            : Yii::t('yii', 'Atualizar a Compra'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                'title' => 'Clique aqui para cadastrar a compra']) ?>

        <input class="btn btn-primary" type='button' id='btnadprodutocompra' value="Adicionar mais um Produto"
               title="Clique aqui para adicionar mais de um produto nesta compra"/>


        <!--   ---------------------------   BEGIN Cadastrar Novo Produto ---------------------------  -->
        <?php
        \yii\bootstrap\Modal::begin([
            'header' => '<h2>Cadastrar Novo Produto</h2>',
            'id' => 'modalnovoproduto',

            'toggleButton' => $model->isNewRecord ?
                ['label' => 'Cadastrar Novo Produto',
                    'class' => 'btn btn-warning',
                    'id' => 'btnovoproduto',
                    'title' => 'Clique aqui para cadastrar um novo produto'
                ] : false,

        ]);
        ?>
        <div class="row">
            <div class="col-lg-6">

                <div class="form-group">

                    <?= Html::label("Nome", ['class' => 'form-control'])
                    ?>
                    <?=
                    Html::input('text', null, null, ['class' => 'form-control',
                        'id' => 'produto-nome', 'placeholder' => 'Digite o nome do novo produto...'])

                    ?>
                </div>
                <div class="form-group">
                    <?= Html::label("Estoque Minímo", ['class' => 'form-control'])
                    ?>
                    <?=
                    Html::input('number', null, 0, ['class' => 'form-control',
                        'id' => 'produto-quantidademinima',
                        'placeholder' => 'Digite o estoque mínimo do novo produto...',
                        'min' => 0, 'step' => 0.01])

                    ?>
                </div>

                <div class="form-group">
                    <?= Html::label("Categoria", ['class' => 'form-control'])
                    ?>
                    <?=
                    $model->isNewRecord ?
                        Html::dropDownList('Produto[idCategoria]', null, $categorias, ['class' => 'form-control',
                            'id' => 'produto-idcategoria', 'prompt' => 'Seleciona a categoria...']) : ''

                    ?>
                </div>


                <?=
                $model->isNewRecord ? Html::Button('Cadastra Novo Produto',
                    ['class' => 'btn btn-success',
                        'id' => 'btCadastrarNovoProduto',
                        'title' => 'Clique aqui para cadastrar um novo produto']) : '' ?>

            </div>

        </div>


        <?php
        \yii\bootstrap\Modal::end();
        ?>

        <!--   ---------------------------   END Cadastrar Novo Produto  ---------------------------  -->
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJsFile(\Yii::getAlias("@web") . '/js/compra_form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<?php

if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?
}
?>
<script type="text/javascript">
    function removeins(id) {
        $('#inputinsumo' + id).removeClass("divborda").empty();
    }
</script>