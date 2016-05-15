<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contasapagar */

$this->title ='Conta: ' . $model->idconta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contasapagars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contasapagar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->idconta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idconta], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'method' => 'post',
            ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
            ['attribute'=>'conta',
            'format'=>'text',
            'label'=>'Conta',
            'value'=>$model->conta->descricao

            ],
            ['attribute'=>'situacaoPagamento',
            'format'=>'text',
            'value'=>$model->situacaoPagamento ? 'Paga' : 'Não paga'
            ],
            ['attribute'=>'dataVencimento',
            'format'=>'text',
            'value'=>
            isset($model->dataVencimento) ?
            \Yii::$app->formatter->asDate($model->dataVencimento, 'dd/MM/yyyy') : null 
            ],
            ],
            ]) ?>

        </div>
