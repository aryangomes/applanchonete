<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CardapioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cardapios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cardapio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Criar Cardapio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idCardapio',
            'data',
            'titulo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
