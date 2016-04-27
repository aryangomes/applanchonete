<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Fornecedor;
/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = 'Compra do dia '.  
$formatter->asDate($model->dataCompra, 'dd/MM/yyyy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="compra-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->idconta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->idconta], [
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

            'descricao',
            'tipoConta',
            'valor',
            [
            'attribute'=>'dataCompra',
            'format'=>'text',
            'value'=>isset($model->dataCompra) ? $formatter->asDate($model->dataCompra, 'dd/MM/yyyy') : null,
            
            ],
            [
            'attribute'=>'dataVencimento',
            'format'=>'text',
            'value'=>isset($model->dataVencimento) ? $formatter->asDate($model->dataVencimento, 'dd/MM/yyyy') : null,
            
            ],
            [
            'attribute'=>'situacaoPagamento',
            'format'=>'text',
            'value'=>isset($model->situacaoPagamento) ? 'Paga': 'Não pago',
            
            ],

          //  'fornecedor_idFornecedor',
          /*  [
            ' format'=>'text',
            'label'=>'Fornecedor',
            'value'=> $fornecedor->nome,
            ],*/
            ],
            ]) ?>

        </div>
