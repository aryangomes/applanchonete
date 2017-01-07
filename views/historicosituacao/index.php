<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistoricosituacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Histórico de Situações do Pedido';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historicosituacao-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idPedido',
            'situacaoPedido.titulo',
            [
                'attribute' => 'dataHora',
                'value' => function ($modelHistorioSituacao) {


                    return
                        ($modelHistorioSituacao->dataHora != null) ?
                            Yii::$app->formatter->asDate($modelHistorioSituacao->dataHora, 'dd/M/Y à\s HH:m') : null;
                }
            ],
            [
                'attribute' => 'user.username',
                'label'=>'Registrado por',
                'value' => function ($modelHistorioSituacao) {

                    return isset($modelHistorioSituacao->user->username)?
                        $modelHistorioSituacao->user->username : null;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
