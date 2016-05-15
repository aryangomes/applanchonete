<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Compraproduto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="compraproduto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idCompra')->textInput() ?>

    <?= $form->field($model, 'idProduto')->textInput() ?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <?= $form->field($model, 'valorCompra')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
