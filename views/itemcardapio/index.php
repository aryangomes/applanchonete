<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemcardapioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Itemcardapios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itemcardapio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Itemcardapio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idCardapio',
            'idProduto',
            'status',
            'ordem',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
