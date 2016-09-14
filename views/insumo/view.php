<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Insumos */

$this->title = 'Insumo: ' . $model->nomeInsumo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Insumos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insumos-view">

    <h1><?= Html::encode($this->title) ?></h1>


        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            
            //'idprodutoVenda',
           // 'idprodutoInsumo',
            [
            'label'=>'Produto Venda',
            'value' =>$model->nomeprodutovenda,
            ],
            'quantidade',
            'unidade',
            ],
            ]) ?>

        </div>
