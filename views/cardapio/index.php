<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CardapioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cardápios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cardapio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Criar Cardápio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'idCardapio',


                [
                    'attribute' =>  'titulo',
                    'format' => 'raw',
                    'value' => function ($modelCardapio) {

                        return Html::a($modelCardapio->titulo, ['view', 'id' => $modelCardapio->idCardapio]);
                    }
                ],
                'data:date',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'header' => 'Ação',
                    'buttons' => [
                        'view' => function ($url, $modelCardapio) {
                            return Html::a('Clique aqui para visualizar detalhes do cardápio <i class="fa fa-search-plus"></i>',
                                \yii\helpers\Url::toRoute(['view', 'id' => $modelCardapio->idCardapio]),
                                [
                                    'title' => Yii::t('app', 'Clique aqui para visualizar detalhes do cardápio'),
                                ]);
                        }
                    ],

                ],
            ],
        ]); ?>

    </div>
</div>