<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Compras');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Compra']), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Orçamento de Compra de Insumos', ['model' => 'OrcamentoCompra']), ['/orcamentocompra/orcamentocomprainsumos'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                'dataCompra:date',

               [
                   'attribute'=> 'conta.valor',
                   'value'=>function($modelCompra){
                        return 'R$ ' . $modelCompra->conta->valor;
                   }
               ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'header' => 'Ação',
                    'buttons' => [
                        'view' => function ($url, $modelCompra) {
                            return Html::a('Clique aqui para visualizar detalhes da compra <i class="fa fa-search-plus"></i>',
                                \yii\helpers\Url::toRoute(['view', 'id' => $modelCompra->idconta]),
                                [
                                    'title' => Yii::t('app', 'Clique aqui para visualizar detalhes da compra'),
                                ]);
                        }
                    ],

                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
