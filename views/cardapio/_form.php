<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Cardapio */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="cardapio-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'data')->widget(DateControl::classname(), [
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

        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>


        <?php
        if ($model->isNewRecord) {
            ?>
            <div id="item">

 <div class="form-group">
     <div class="row">
         <div class="col-md-6">
                <?= $form->field($modelItemCardapio, 'idProduto[]')->dropDownList(
                    $produtos,
                    ['onChange'=>'funcao1(this)']
                ) ?>
         </div>
           <div class="col-md-6">
           Imagem
               <img src="" class="img-responsive">
           </div>
     </div>
                <?= $form->field($modelItemCardapio, 'ordem[]')->textInput(['type' => 'number', 'step' => 1, 'min' => 0]) ?>

                <input type="button" id="btRemoverItemCardapio"
                       value="Remover"
                       class="btn btn-primary" onclick="removerItemCardapio(this)"
                />
            </div>
            </div>

            <?php
        } else {
            ?>
            <div id="item">
                <div class="form-group">
                    <?= Html::label('Produto') ?>
                    <?= Html::dropDownList('Itemcardapio[idProduto][]', $itensCardapio[0]->idProduto, $produtos,
                        ['class' => 'form-control']) ?>

                    <?= $form->field($itensCardapio[0], 'ordem[]')->textInput(['type' => 'number', 'step' => 1, 'min' => 0,
                        'value' => $itensCardapio[0]->ordem]) ?>
                    <input type="button" id="btRemoverItemCardapio"
                           value="Remover"
                           class="btn btn-primary" onclick="removerItemCardapio(this)"
                    />
                </div>

            </div>

            <?php
            for ($i = 1; $i < count($itensCardapio); $i++) {
                ?>
                <div class="form-group" id="itemcardapio<?=$i?>">
                    <?= Html::label('Produto') ?>
                    <?= Html::dropDownList('Itemcardapio[idProduto][]', $itensCardapio[$i]->idProduto, $produtos,
                        ['class' => 'form-control']) ?>

                    <?= $form->field($itensCardapio[$i], 'ordem[]')->textInput(['type' => 'number', 'step' => 1, 'min' => 0,
                        'value' => $itensCardapio[$i]->ordem]) ?>

                    <input type="button"
                           value="Remover"
                           class="btn btn-primary" onclick="remover('<?= $i?>')"
                    />


                </div>
                <?php
            } ?>

            <?php
            ?>

            <?php

        }
        ?>


        <div id="more"></div>


        <?php
        $this->registerJsFile(\Yii::getAlias('@web') . "/js/cardapio_form.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
        ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::Button('Adicionar mais um Item Cardápio', ['class' => 'btn btn-primary',
                    'id' => 'btAddItem']
            ) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>


<?php

if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>