<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use  yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Produto */

$this->title = $model->idProduto;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idProduto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idProduto], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
            ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            'idProduto',
            'nome',
            'valorVenda',
            'isInsumo',
            'quantidadeMinima',
            'idCategoria',
            'quantidadeEstoque',
            [
            'label'=>'Preço sugerido',
            'format'=>'text',
            'value'=> $model->isInsumo ? null :  ($model->calculoprecoproduto($model->idProduto)),
            ],

            ],
            ]) ?>


        <?php 

        if (!$model->isInsumo) {
            echo Html::a('Avaliar produto <i class="fa fa-line-chart"></i>', 
                Url::toRoute(['produto/avaliacaoproduto', 'idproduto'=>$model->idProduto]),
                ['class' =>  'btn btn-primary btn-block']);
        }
        ?>
    </div>
