<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelFormapagamento app\models\Formapagamento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="formapagamento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelFormapagamento, 'titulo')->textInput(['maxlength' => true,
    'placeholder'=>'Digite a forma de pagamento']) ?>

    <?= $form->field($modelFormapagamento, 'descricao')->textarea(['rows' => 6,
        'placeholder'=>'Digite a descrição de forma de pagamento']) ?>

    <div class="form-group">
        <?= Html::submitButton($modelFormapagamento->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelFormapagamento->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
