<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Despesa */

$this->title = $model->nomedespesa;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Despesas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despesa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->iddespesa], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->iddespesa], [
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
           // 'iddespesa',
            'nomedespesa',
            'valordespesa',
            [
            'attribute'=>'situacaopagamento',
            'format'=>'text',
            
            'value'=>  $model->situacaopagamento ? 
            'Pago' : 'Não Pago',    
            

            ],
            [
            'attribute'=>'datavencimento',
            'format'=>'text',
            'value'=>
            $formatter->asDate($model->datavencimento, 'dd/MM/yyyy')
            
            ],
            ],
            ]) ?>

        </div>
