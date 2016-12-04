<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $modelPedido app\models\Pedido */
/* @var $mensagem mixed */
/* @var $form yii\widgets\ActiveForm */
/* @var $itemPedido \app\models\Itempedido */
/* @var $produtosVenda array */
/* @var $situacaopedido array */
/* @var $mesa array */
?>

<?php

if (isset($mensagem) && !empty($mensagem)) {

    ?>

    <div class="alert alert-danger">
        <?= $mensagem ?>
    </div>
    <?php

}
?>

<div class="pedido-form">


    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($modelPedido, 'idSituacaoAtual')
        ->dropDownList($situacaopedido, ['prompt' => 'Selecione a situação do pedido'])
    ?>
    <?php
    if (Yii::$app->controller->action->id == 'create') {
        //Cadastrar
        ?>
        <?=
        $form->field($modelPedido, 'idMesa')->widget(Select2::classname(), [
            'data' => $mesa,
            'options' => ['placeholder' => 'Selecione a mesa'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
        ?>

        <div class="divborda">
            <div class="row">
                <div class="col-md-6">
                    <?=
                    $form->field($itemPedido, 'idProduto[]')->widget(Select2::classname(), [
                        'data' => $produtosVenda,
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
            $form->field($itemPedido, 'quantidade[]')->textInput(['type' => 'number', 'value' => 1, 'min' => 1]);
            ?>

        </div>
        <?php
    } else {

        ?>


        <?=
        $form->field($modelPedido, 'idMesa')->widget(Select2::classname(), [
            'data' => $mesa,
            'options' => ['placeholder' => 'Selecione a mesa'],
//            'disabled'=>true,
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
        ?>
        <?php
        //Atualizar
        echo $form->field($modelPedido, 'idPedido')->hiddenInput(['id' => 'idpedido'])
            ->label(false);


        for ($i = 0; $i < count($itemPedido); $i++) {
            ?>
            <div class="form-group field-insumos-idprodutoinsumo required divborda" id="<?= 'inputinsumo' . $i ?>">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group field-itempedido-idproduto required has-success">
                        <?php
                        echo Html::activeLabel($itemPedido[$i], 'idProduto', ['class' => 'control-label']);
                        echo Select2::widget([
                            'model' => $itemPedido[$i],
                            'name' => 'Itempedido[idProduto][]',
                            'value' => $itemPedido[$i]->idProduto,
                            'data' => $produtosVenda,
                            'options' => ['placeholder' => 'Selecione o insumo',
                                'id' => 'idinsumo' . $i,
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                            'pluginEvents' => [
                                "change" => "function() {
                                mudarFoto(this);
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
                        <div class="help-block-insumo<?= $i ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        Imagem
                        <img width="200" src="<?=
                        ($itemPedido[$i]->produto->foto) ?
                            'data:image/jpeg;base64,' . base64_encode($itemPedido[$i]->produto->foto) :
                            '../imgs/semfoto.jpg' ?>" class="img-responsive">
                    </div>
                </div>
                <?php
                echo "</br>";

                echo $form->field($itemPedido[$i], 'quantidade[]')->textInput(['type' => 'number', 'value' => $itemPedido[$i]->quantidade, 'min' => 1]);
                ?>
                <input class="btn btn-danger" onclick="removeins(<?= $i ?>)" type='button' value="Remover Item Pedido"
                       title='Remover item do pedido'>

            </div>
            </br>
            <?php
        }
    }
    ?>

    <div class="table-responsive" id="input-dinamico">

    </div>

    <?php
    $options = array();
    $opt = "<option value=\"\">Selecione um produto</option>";
    array_push($options, $opt);
    foreach ($produtosVenda as $k => $v) {
        $opt = "<option value=\"" . $k . "\">" . $v . "</option>";
        array_push($options, $opt);
    }
    $o = implode("", $options);

    $this->registerJs('var i = 1; $("#btnadprodutocompra").on("click",function(){'
        . '$("#input-dinamico").append(\'<div class="divborda" id="inputinsumo\'+i+\'" ><div class="form-group field-itempedido-idprodutoinsumo required"><div class="row"><div class="col-md-6"><div class="form-group field-itempedido-idproduto required has-success"><label class="control-label" for="itempedido-idprodutoinsumo">Produto</label><select onChange="mudarFoto(this)" id="itempedido-idproduto" class="form-control" name="Itempedido[idProduto][]" >' . $o . '</select><div class="help-block"></div></div></div><div class="col-md-6">Imagem<img width="200" src="" class="img-responsive"></div></div><div class="form-group field-itempedido-quantidade required"><label class="control-label" for="quantidade\'+i+\'">Quantidade</label><input type="number" id="quantidade\'+i+\'" class="form-control" name="Itempedido[quantidade][]" value="1" min="1" step="1"><div class="help-block"></div></div><input class="btn btn-danger" onclick="removeins(\'+i+\')" type="button" value="Remover Item Pedido"></div><hr></div>\');'
        . '$("[name=\'Itempedido[idProduto][]\']").select2();i = i+1;'
        . '$("span[class=\'select2 select2-container select2-container--default select2-container--focus\']")'
        . '.addClass("select2 select2-container select2-container--krajee select2-container--focus")'
        . '.removeClass("select2 select2-container select2-container--default select2-container--focus");'
        . '})');
    ?>

    <?php
    $this->registerJsFile(\Yii::getAlias("@web") . '/js/pedido_form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    ?>
    <div class="form-group">
        <?php if (isset($modelPedido->idSituacaoAtual)) {
            if ($modelPedido->situacaopedido->titulo != 'Concluído') {
                echo Html::submitButton($modelPedido->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'),
                    ['class' => $modelPedido->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                        'title'=>$modelPedido->isNewRecord ? 'Clique para cadastrar um novo Pedido':
                            'Clique para salvar os dados do Pedido']);
            }
        } else {
            echo Html::submitButton($modelPedido->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $modelPedido->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);

        } ?>

        <?php if (isset($modelPedido->idSituacaoAtual)) {
            if ($modelPedido->situacaopedido->titulo != 'Concluído') {
                ?>
                <input class="btn btn-primary" type='button' id='btnadprodutocompra' value="Adicionar Item do Pedido"
                       title="Adicionar mais um item ao Pedido">
            <?php }
        } else {
            ?>
            <input class="btn btn-primary" type='button' id='btnadprodutocompra' value="Adicionar Item do Pedido"
                   title="Adicionar mais um item ao Pedido">

            <?php
        }
        ?>
    </div>


    <?php ActiveForm::end(); ?>


</div>


<script type="text/javascript">
    function removeins(id) {
        $('#inputinsumo' + id).removeClass("divborda").empty();
    }
</script>