<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categorias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Categorias']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'idCategoria',

                [
                    'attribute' => 'nome',
                    'format' => 'raw',
                    'value' => function ($modelCategoria) {

                        return Html::a($modelCategoria->nome, ['view', 'id' => $modelCategoria->idCategoria]);
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>

    </div>
</div>