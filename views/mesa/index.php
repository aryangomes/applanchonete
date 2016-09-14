<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MesaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mesas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mesa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mesa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'idMesa',
                'descricao',
                [
                    'attribute' => 'disponivel',
                    'value' => function ($model) {
                        return $model->disponivel ? 'Disponível' : 'Não Disponível';
                    }

                ],
                [
                    'attribute' => 'alerta',
                    'value' => function ($model) {
                        return $model->alerta ? 'Ligado' : 'Desligado';
                    }

                ],

//            'qrcode',
                // 'chave',
                // 'cont',

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'header' => 'Ação',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('Clique aqui para visualizar detalhes da mesa<i class="fa fa-search-plus"></i>',
                                \yii\helpers\Url::toRoute(['view', 'id' => $model->idMesa]),
                                [
                                    'title' => Yii::t('app', 'Clique aqui para visualizar detalhes da mesa'),
                                ]);
                        }
                    ],

                ],
            ],
        ]); ?>
    </div>
</div>
