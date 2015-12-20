<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Fornecedor;
/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = 'Compra do dia '.$model->datacompra;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$fornecedor = new Fornecedor();
$fornecedor = $fornecedor::getNomeFornecedor($model->fornecedor_idFornecedor);

?>
<div class="compra-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->idcompra], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->idcompra], [
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
            'datacompra:date',
            'totalcompra',
            //'idcompra',
          //  'fornecedor_idFornecedor',
            [
            ' format'=>'text',
            'label'=>'Fornecedor',
            'value'=> $fornecedor->nome,
            ],
            ],
            ]) ?>

        </div>
