<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PedidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pedidos');
$this->params['breadcrumbs'][] = $this->title;
//date_default_timezone_set('America/Sao_Paulo');
?>
<div class="pedido-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Pedido']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                ['attribute' => 'situacaopedido',
                    'label' => 'Situação Atual',
                    'value' => 'situacaopedido.titulo'],
                [
                    'attribute' => 'totalPedido',
                    'value' => function ($model) {
                        return 'R$ ' . $model->totalPedido;
                    }
                ],
                [
                    'label'=>'Itens do Pedido (Produto/Quantidade)',
                    'value' => function ($model) {
                    $itensPedidos = $model->getItensPedido();
                        $results = [];
                      for ($i = 0 ; $i < count($itensPedidos);$i++){
                            $str = $itensPedidos[$i][0].'('.$itensPedidos[$i][1].')' ;
                            array_push($results,$str);
                        }
                       return(    implode(", ",$results));

                    }
                ],
                [
                    'attribute' => 'historicosituacaos.dataHora',
                    'value' => function ($model) {


                        return
                            ($model->getDataHoraPedido() != null) ?
                                date("d/m/Y H:i",
                                    strtotime($model->getDataHoraPedido())) : null;
                    }
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('Clique aqui para visualizar detalhes do pedido',
                                \yii\helpers\Url::toRoute(['view', 'id' => $model->idPedido]),
                                [
                                    'title' => Yii::t('app', 'Clique aqui para visualizar detalhes do pedido'),
                                ]);
                        }
                    ],

                ],


            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
