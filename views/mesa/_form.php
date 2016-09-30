<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelMesa app\models\Mesa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mesa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelMesa, 'descricao')->textarea(['maxlength' => true,
    'placeholder'=>'Digite a descrição da mesa']) ?>

    <?= $form->field($modelMesa, 'disponivel')->dropDownList([
        '1'=>'Disponível','0'=>'Não Disponível'
    ],['prompt'=>'Selecione...']) ?>





    <div class="form-group">
        <?= Html::submitButton($modelMesa->isNewRecord ? 'Cadastrar' : 'Alterar', ['class' => $modelMesa->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
