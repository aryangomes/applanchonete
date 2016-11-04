<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $modelRelatorio app\models\Relatorio */
/* @var $form yii\widgets\ActiveForm */
/* @var $tiposRelatorio array */
?>

<div class="relatorio-form">

   <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($modelRelatorio, 'datageracao' )->hiddenInput(['value'=> date('Y-m-d')])->label(false); ?>

   <?= $form->field($modelRelatorio, 'tipo')->dropDownList(
       $tiposRelatorio,
    ['prompt'=>'Selecione o tipo de relatório']) ?>



   <?= $form->field($modelRelatorio, 'inicio_intervalo')->widget(DateControl::classname(), [
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

   <?= $form->field($modelRelatorio, 'fim_intervalo')->widget(DateControl::classname(), [
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
    <?= $form->field($modelRelatorio, 'usuario_id' )->hiddenInput(['value'=>Yii::$app->user->getId()])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($modelRelatorio->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'),
            ['class' => $modelRelatorio->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                'title'=>$modelRelatorio->isNewRecord ? 'Clique para cadastrar um novo Relatório':
                    'Clique para salvar os dados do Relatório']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
