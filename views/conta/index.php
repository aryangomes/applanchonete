<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $modelConta \app\models\Conta */

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


                [
                    'attribute' =>  'tipoConta',
                    'format' => 'raw',
                    'value' => function ($modelConta) {

                        return Html::a($modelConta->getTipoConta(), ['view', 'id' => $modelConta->idconta]);
                    }
                ],
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

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>