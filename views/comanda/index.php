<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ComandaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comandas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comanda-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Comanda', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idComanda',
            'desconto',
            'totalPago',
            'dataHoraAbertura',
            'dataHoraFechamento',
            // 'descricao:ntext',
            // 'status',
            // 'totalPedidos',
            // 'mesaIdMesa',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
