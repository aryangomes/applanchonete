<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Situacaopedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="situacaopedido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true,
        'placeholder'=>"Digite como vai se chamar a Situação do Pedido"]) ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6,
        'placeholder'=>"Digite a descrição da Situação do Pedido"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
