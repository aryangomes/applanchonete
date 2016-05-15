<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ItempedidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Item pedido');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itempedido-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model'=>'Item pedido']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'idPedido',
       // 'idProduto',
        [
        'label'=>'Produto',
        'format'=>'text',
        'value'=> function ($model)
        {
            return $model->nomeProduto;
        }
        ],
        'quantidade',
        'total',

        ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>
        <?php Pjax::end(); ?></div>
