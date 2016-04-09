<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InsumosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Create {model}', ['model'=>'Insumo']);
$this->params['breadcrumbs'][] = 'Insumos';
?>
<div class="insumos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model'=>'Insumo']), ['produto/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
     //   ['class' => 'yii\grid\SerialColumn'],

        //'idprodutoVenda',
        'nomeInsumo',
        [
        'label'=>'Produto de Venda',
        'value' =>'nomeprodutovenda',
        ],
        [
        'label'=>'Quantidade',
        'value' =>function ($model)
        {
            return $model->quantidade . ' ' . $model->unidade;
        },
        ],
     /*   'quantidade',
     'unidade',*/

     ['class' => 'yii\grid\ActionColumn',
     'template' => '{view} {update} {alterarinsumo} {delete} ',
     'buttons' => [
     'update' => function ($url, $model) {
        return Html::a('<i class="glyphicon glyphicon-pencil"></i>',
            Url::toRoute(['insumos/update', 'idprodutoVenda'=>$model->idprodutoVenda,
                'idprodutoInsumo'=>$model->idprodutoInsumo]),
            [
            'title' => Yii::t('app', 'Alterar Insumo no produto ' . $model->nomeprodutovenda),
            ]);
    },
    'alterarinsumo' => function ($url, $model) {
        return Html::a('<i class="glyphicon glyphicon-edit"></i>',
            Url::toRoute(['produto/update', 'id'=>$model->idprodutoInsumo]),
            [
            'title' => Yii::t('app', 'Alterar Insumo'),
            ]);
    }
    ],
    ],
    ],
    ]); ?>

</div>
