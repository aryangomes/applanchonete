<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Produto */

$this->title = 'Lista de insumos de um Produto';

?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>
    <?= '<label class="control-label">Produto Venda</label>'; ?>
    <?= Select2::widget([
        'name' => 'produtovenda',
        'data' => $produtosVenda,
        'options' => [
        'placeholder' => 'Digite o produto venda',
      //  'multiple' => true
        ],
        ]);?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <?php 
        if (isset($insumos)) {
            foreach ($insumos as $insumo) {
                echo($insumo->nome). '</br>';
            }
        }

        ?>

    </div>
