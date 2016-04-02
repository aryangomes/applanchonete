<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Produto */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valorVenda')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
        'prefix' => 'R$ ',
        
        'allowNegative' => false,
        ]
        ]); ?>

    <?=  $form->field($model, 'isInsumo')->widget(SwitchInput::classname(), [
        'pluginOptions' => [
        'size' => 'mini',
        'onText' => 'É insumo',
        'offText' => 'Não é insumo',

        ],

        ]); ?>

        <?= $form->field($model, 'quantidadeMinima')->textInput([ 'type' => 'number', 'value'=>0]) ?>

        <?= 
        $form->field($model, 'idCategoria')->widget(Select2::classname(), [
            'data' => $categorias,
            'options' => ['placeholder' => 'Seleciona a categoria'],
            'pluginOptions' => [
           // 'allowClear' => true
            ],
            ]);
            ?>

            <?= $form->field($model, 'quantidadeEstoque')->textInput([ 'type' => 'number', 'value'=>0]) ?>





            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
