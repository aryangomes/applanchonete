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
        <?= Html::a('Cadastrar   Mesa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                [
                    'attribute' => 'idMesa',
                    'format' => 'raw',
                    'value' => function ($modelMesa) {

                        return Html::a('Mesa: '.$modelMesa->idMesa, ['view', 'id' => $modelMesa->idMesa]);
                    }
                ],
                'numeroDaMesa',
                [
                    'attribute' => 'disponivel',
                    'value' => function ($modelMesa) {
                        return $modelMesa->disponivel ? 'Disponível' : 'Não Disponível';
                    }

                ],
                [
                    'attribute' => 'alerta',
                    'value' => function ($modelMesa) {
                        return $modelMesa->alerta ? 'Ligado' : 'Desligado';
                    }

                ],

//            'qrcode',
                // 'chave',
                // 'cont',

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'header' => 'Ação',
                    'buttons' => [
                        'view' => function ($url, $modelMesa) {
                            return Html::a('Clique aqui para visualizar detalhes da mesa<i class="fa fa-search-plus"></i>',
                                \yii\helpers\Url::toRoute(['view', 'id' => $modelMesa->idMesa]),
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
