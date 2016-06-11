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
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        ['attribute'=>'conta',
        'format'=>'text',
        'label'=>'Conta',
        'value'=>function ($model)
        {
            return $model->conta->descricao;
        }
        ],
        ['attribute'=>'dataHora',
        'format'=>'text',
        'value'=>function ($model)
        {
            return isset($model->dataHora) ?
            \Yii::$app->formatter->asDate($model->dataHora, 'dd/MM/yyyy H:m') : null ;
        }
        ],

        ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>
        <?php Pjax::end(); ?></div>