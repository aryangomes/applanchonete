<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CaixaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::t('app', 'Caixa');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caixa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <p>
        <?= Html::a(Yii::t('app', 'Abrir Caixa',
        ['model'=>Yii::t('app','Caixa')]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php  /*GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],


        'valorapurado',
        'valoremcaixa',
        'valorlucro',

        ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); */?>

    </div>
