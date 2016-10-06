<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContasapagarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contas a pagar');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contasapagar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a(Yii::t('app', 'Create {model}',['model'=>'Contas a pagar']), ['create'], ['class' => 'btn btn-success']) ?>
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
                    'attribute' => 'conta',
                    'format' => 'raw',
                    'value' => function ($modelContasapagar) {

                        return Html::a($modelContasapagar->conta->descricao, ['view', 'id' => $modelContasapagar->idconta]);
                    }
                ],

                ['attribute' => 'dataVencimento',
                    'format' => 'text',
                    'value' => function ($modelContasapagar) {
                        return isset($modelContasapagar->dataVencimento) ?
                        date('d/m/Y',strtotime($modelContasapagar->dataVencimento)) : null;
                    }
                ],


                ['class' => 'yii\grid\ActionColumn' ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>