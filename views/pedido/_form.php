<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pedido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php /* $form->field($model, 'totalPedido')->widget(MaskMoney::classname(), [
      'pluginOptions' => [
      'prefix' => 'R$ ',

      'allowNegative' => false,
      ]
      ]); */ ?>

    <?= $form->field($model, 'idSituacaoAtual')->dropDownList($situacaopedido, ['prompt' => 'Selecione a situação do pedido']) ?>


   
    <div class="itempedido-form"  id="itempedido-form">
<?php for ($i = 0 ;$i <count($itemPedido); $i++){ ?>
        <div id="ip<?= ($i+1) ?>"  class="form-group">
 <?php 
    
//       echo  $form->field($model->isNewRecord ? $itemPedido: $itemPedido[$i], 'idProduto[]')
//        ->dropDownList($produtosVenda,[
//            'id'=>'select1'
//            
//        ]);
               echo Html::label('Produto');
               echo Html::dropDownList('Itempedido[idProduto][]', 
                       $model->isNewRecord ? '': $itemPedido[$i]->idProduto, $produtosVenda,
                       [
            'id'=>'select1','class'=>'form-control'
                       
        ]);
        ?>

        <?=
        $form->field($model->isNewRecord ? $itemPedido: $itemPedido[$i], 'quantidade[]')->textInput([ 'type' => 'number',
            'min' => 1, 'step' => '1', 'placeholder' => 'Digite a quantidade',
            'value'=>$model->isNewRecord ? 0: $itemPedido[$i]->quantidade,
                ])
        ?>
   <?= Html::Button('Remover Item Pedido', 
           ['class' =>  'btn btn-default', 'id'=>'btRemoverItemPedido'.($i+1),
               'onClick'=> "removerItemPedido(".($i+1).")",
                ] 
           ) ?>
        </div>
          

    </div>   
  <div id="more-item-pedido">
          
        </div>
    
    <?php }?>
    <?php
    $this->registerJsFile(\Yii::getAlias("@web") . '/js/pedido_form.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   <?= Html::Button('Adicionar Item Pedido', 
           ['class' =>  'btn btn-default', 'id'=>'btAdicionarItemPedido']) ?>
        
         

    </div>


    <?php ActiveForm::end(); ?>

</div>
