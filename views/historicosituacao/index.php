<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistoricosituacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historicosituacaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historicosituacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Historicosituacao', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idPedido',
            'idSituacaoPedido',
            'dataHora',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
