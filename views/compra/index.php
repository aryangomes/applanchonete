<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Fornecedor;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CompraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Compras');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}',
        ['model'=>Yii::t('app','Compra')]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'idconta',
        'valor',
        'descricao:ntext',
        'tipoConta',
        [
        'attribute'=>'situacaoPagamento',
        'format'=>'text',
        
        'value'=> function($model){

            return $model->situacaoPagamento ? 'Pago':'Não pago';
        }

        ],

            // 'dataVencimento',
            // 'dataCompra',

        [
        'attribute'=>'dataCompra',
        'format'=>'text',

        'value'=> function($model){
            $formatter = \Yii::$app->formatter;
            return $formatter->asDate($model->dataCompra, 'dd/MM/yyyy');
        }

        ],

        [
        'attribute'=>'dataVencimento',
        'format'=>'text',

        'value'=> function($model){
            $formatter = \Yii::$app->formatter;
            return isset($model->dataVencimento) ? $formatter->asDate($model->dataVencimento, 'dd/MM/yyyy') 
            : null;
        }

        ],

        ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>

    </div>
