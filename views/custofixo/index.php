<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustofixoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Custos fixos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custofixo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Tipo de Custo Fixo']), ['tipocustofixo/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                'consumo',

                [
                    'attribute' => 'tipocustofixoIdtipocustofixo',
                    'label' => 'Tipo de Custo Fixo',
                    'value' => 'tipocustofixoIdtipocustofixo.tipocustofixo'

                ],

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'header' => 'Ação',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('Clique aqui para visualizar detalhes do custo fixo<i class="fa fa-search-plus"></i>',
                                \yii\helpers\Url::toRoute(['view', 'id' => $model->idconta]),
                                [
                                    'title' => Yii::t('app', 'Clique aqui para visualizar detalhes do custo fixo'),
                                ]);
                        }
                    ],

                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>