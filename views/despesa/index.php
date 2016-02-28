<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DespesaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Despesas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="despesa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}',
        ['model'=>Yii::t('app','Despesa')]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        
        'nomedespesa',
        'valordespesa',
        [
        'attribute'=>'situacaopagamento',
        'format'=>'text',

        'value'=> function($model){

            return $model->situacaopagamento ? 'Pago' : 'Não Pago';
        }

        ],
        [
        'attribute'=>'datavencimento',
        'format'=>'text',
        
        'value'=> function($model){
            $formatter = \Yii::$app->formatter;
            return $formatter->asDate($model->datavencimento, 'dd/MM/yyyy');
        }

        ],

        ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>

    </div>
