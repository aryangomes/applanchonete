<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Produto */

$this->title = 'Lista de produtos de venda por insumo';

?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(); ?>
    <?= '<label class="control-label">Insumo</label>'; ?>
    <?= Select2::widget([
        'name' => 'idinsumo',
        'data' => $insumos,
        'options' => [
        'placeholder' => 'Digite o insumo',
      //  'multiple' => true
        ],
        ]);?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <div class="panel panel-default">

            <?php 
            if (isset($produtosVenda)) {
                ?> <div class="panel-heading">Produtos Venda</div> <?php
                foreach ($produtosVenda as $pv) {
                    ?> <div class="panel-body"><?= $pv->nome ?></div><?php
                }
            }

            ?>
        </div>
    </div>
