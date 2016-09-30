<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\RangeInput;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $modelProduto app\models\Produto */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Definir Valor de ' . $modelProduto->nome);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelProduto->nome, 'url' => ['view', 'id' => $modelProduto->idProduto]];
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="/applanchonete/web/admin/js/jquery.js"></script>
<div class="produto-create">
    <div class="produto-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($modelProduto, 'nome')->textInput(['maxlength' => true])->label('Produto Venda') ?>

        <?= $form->field($modelProduto, 'valorVenda')->widget(MaskMoney::classname(), [
            'options' => ['disabled' => true,
              ],
            'pluginOptions' => [
                'prefix' => 'R$ ',

                'allowNegative' => false,
            ]
        ]); ?>
        <p>
        <?=  Html::label('Preço de Custo de Produto')?>
     
        <?= 
       
        MaskMoney::widget([
    'name' => 'calculoPrecoProduto',
    'value' => $modelProduto->calculoPrecoProduto($modelProduto->idProduto),
            'options' => ['id' => 'valorantigo',],
]);
        ?>

   </p>
        <?= $form->field($modelProduto, 'valorVenda')->widget(MaskMoney::classname(), [
            'options' => ['id' => 'valornovo',],
            'pluginOptions' => [
                'prefix' => 'R$ ',

                'allowNegative' => false,
            ]
        ])->label('Novo valor de venda'); ?>


        <?= $form->field($modelProduto, 'nome')->widget(MaskMoney::classname(), [
            'options' => ['id' => 'diferencavalor',],
            'pluginOptions' => [
                'prefix' => 'R$ ',

                'allowNegative' => false,
            ]
        ])->label('Valor concreto em R$ do lucro'); ?>


        <div class="group field-produto-porcentagemLucro">
            <p>   <?=
                '<label class="control-label">Porcentagem de Lucro</label>' ?>

                <?=
                RangeInput::widget([
                    'name' => 'porcentagemLucro',
                    'value' => 0,
                    'html5Options' => ['min' => 0, 'max' => 100],
                    'addon' => ['append' => ['content' => '%']]
                ]);
                ?>
            </p>
        </div>


        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Salvar valor'),
                ['class' => $modelProduto->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<script>

    $(document).ready(function () {
        var valorantigo = parseFloat($("#valorantigo-disp").val());
        $("#w1-source").change(function () {
            console.log('valorantigo '+valorantigo);
            var porcentagem = parseFloat($("#w1-source").val());

            porcentagem /= 100.0;


            var novoValor = parseFloat((valorantigo + (valorantigo * porcentagem)));
            $("#diferencavalor-disp").val((valorantigo * porcentagem).toFixed(2));
            $("#diferencavalor-disp").maskMoney('mask');
            $("#valornovo-disp").val(parseFloat(novoValor).toFixed(2));

            $("#valornovo-disp").maskMoney('mask');
        })

    });

</script>