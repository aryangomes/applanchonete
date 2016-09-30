<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelProduto app\models\Produto */
/* @var $insumos array */
/* @var $nomeInsumo mixed */

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
            'required' => true,
            'placeholder' => 'Digite o insumo',
            //  'multiple' => true
        ],
    ]); ?>
    </br>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="panel panel-default">

        <?php
        if (isset($produtosVenda)) {
            ?>
            <div class="panel-heading">Produtos de venda que possuem o insumo <?= $nomeInsumo ?> em sua composição
            </div> <?php
            foreach ($produtosVenda as $pv) {
                ?>
                <div
                    class="panel-body"><?= Html::a($pv->nome, Url::toRoute(['view', 'id' => $pv->idProduto])) ?></div><?php
            }
        }

        ?>
    </div>
</div>
