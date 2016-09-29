<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelTipocustofixo app\models\Tipocustofixo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipocustofixo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelTipocustofixo, 'tipocustofixo')->textInput(['maxlength' => true,
    'placeholder'=>'Digite o Tipo de Custo Fixo']) ?>

    <div class="form-group">
        <?= Html::submitButton($modelTipocustofixo->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelTipocustofixo->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
