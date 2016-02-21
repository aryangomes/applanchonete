<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PagamentoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pagamento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idPagamento') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'dataHora') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'tipoPagamento_idTipoPagamento') ?>

    <?php // echo $form->field($model, 'idComanda') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
