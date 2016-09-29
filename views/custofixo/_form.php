<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelCustofixo app\models\Custofixo */
/* @var $tiposCustoFixo array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="custofixo-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= $form->field($modelCustofixo, 'consumo')->textInput(['maxlength' => true,'placeholder'=>'Digite o consumo']) ?>

    <?= $form->field($modelCustofixo, 'tipocustofixo_idtipocustofixo')->dropDownList($tiposCustoFixo,[
        'prompt'=>'Selecione o tipo de Custo Fixo'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($modelCustofixo->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelCustofixo->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
