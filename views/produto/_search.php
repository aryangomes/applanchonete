<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProdutoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="produto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idProduto') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'valorVenda') ?>

    <?= $form->field($model, 'isInsumo') ?>

    <?= $form->field($model, 'quantidadeMinima') ?>

    <?php // echo $form->field($model, 'idCategoria') ?>

    <?php // echo $form->field($model, 'quantidadeEstoque') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
