<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model app\models\Relatorio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="relatorio-form">

   <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'datageracao' )->hiddenInput(['value'=> date('Y-m-d')])->label(false); ?>

   <?= $form->field($model, 'tipo')->dropDownList([
    'Compras'=>'Compras',
    'Despesas'=>'Não Despesas',
    'Faturamento'=>'Faturamento',
    'Estoque'=>'Estoque',
    'Saída de produtos'=>'Saída de produtos',
    'Lucro'=>'Lucro',
    'Lucro do produto'=>'Lucro do produto',], 
    ['prompt'=>'Selecione o tipo de relatório']) ?>



   <?= $form->field($model, 'inicio_intervalo')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,
    'ajaxConversion'=>false,
    'options' => [

    'pluginOptions' => [
    'autoclose' => true
    ]
    ],
    'displayFormat' => 'dd/MM/yyyy',
    'language'=>'pt',
    ]);?>

   <?= $form->field($model, 'fim_intervalo')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,
    'ajaxConversion'=>false,
    'options' => [

    'pluginOptions' => [
    'autoclose' => true
    ]
    ],
    'displayFormat' => 'dd/MM/yyyy',
    'language'=>'pt',
    ]); ?>

    <?=  $form->field($model, 'usuario_id')->dropDownList([1=>'Usuario 1',2=>'Usuario 2'], ['prompt'=>'Selecione o usuário'])  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
