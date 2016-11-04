<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelMesa app\models\Mesa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mesa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelMesa, 'numeroDaMesa')->textInput(['maxlength' => true,
        'placeholder' => 'Digite o número da mesa', 'type' => 'number', 'min' => 1]) ?>


    <div class="form-group">
        <?= Html::submitButton($modelMesa->isNewRecord ? 'Cadastrar' : 'Alterar',
            ['class' => $modelMesa->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                'title'=>$modelMesa->isNewRecord ? 'Clique para cadastrar uma nova Mesa':
                    'Clique para salvar os dados da Mesa']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
