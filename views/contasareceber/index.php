<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContasareceberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contas a receber');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contasareceber-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a(Yii::t('app', 'Create {model}',['model'=>'Conta a receber']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                [
                    'attribute' => 'conta',
                    'format' => 'raw',
                    'value' => function ($modelContasareceber) {

                        return Html::a($modelContasareceber->conta->descricao, ['view', 'id' => $modelContasareceber->idconta]);
                    }
                ],


                ['attribute' => 'dataHora',
                    'format' => 'text',
                    'value' => function ($modelContasareceber) {
                        return isset($modelContasareceber->dataHora) ?
                            date("d/m/Y H:i", strtotime($modelContasareceber->dataHora)) : null;
                    }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>