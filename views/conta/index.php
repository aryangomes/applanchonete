<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Conta']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'idconta',

                'tipoConta',
                ['attribute' => 'valor',
                    'format' => 'text',
                    'value' => function ($modelConta) {
                        return 'R$ '. number_format( $modelConta->valor,2);
                    }
                ],
                'descricao:ntext',

                ['attribute' => 'situacaoPagamento',
                    'format' => 'text',
                    'value' => function ($modelConta) {
                        return $modelConta->situacaoPagamento ? 'Paga' : 'Não paga';
                    }
                ],

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'header' => 'Ação',
                    'buttons' => [
                        'view' => function ($url, $modelConta) {
                            return Html::a('Clique aqui para visualizar detalhes da conta <i class="fa fa-search-plus"></i>',
                                \yii\helpers\Url::toRoute(['view', 'id' => $modelConta->idconta]),
                                [
                                    'title' => Yii::t('app', 'Clique aqui para visualizar detalhes da conta'),
                                ]);
                        }
                    ],

                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>