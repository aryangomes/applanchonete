<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelPagamento app\models\Pagamento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pagamento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelPagamento, 'idConta')->textInput() ?>

    <?= $form->field($modelPagamento, 'idPedido')->textInput() ?>

    <?= $form->field($modelPagamento, 'formapagamento_idTipoPagamento')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($modelPagamento->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $modelPagamento->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
