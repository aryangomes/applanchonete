<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProdutoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Produtos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model'=>'Produto']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'idProduto',
        'nome',
        'valorVenda',
        [
        'attribute'=>  'isInsumo',
        'format'=>'text',
        'value'=> function($model){

            return $model->isInsumo ? 'Sim' : 'Não';
        }
        ],
        [
        'attribute'=>  'quantidadeEstoque',
        'format'=>'text',

        'value'=> function($model){

            return $model->isInsumo ? $model->quantidadeEstoque : null ;
        }
        ],

            // 'idCategoria',
            // 'quantidadeEstoque',

        ['class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {delete} {avaliarproduto}',
        'buttons' => [
        'avaliarproduto' => function ($url, $model) {
            return $model->isInsumo ?'' : Html::a('<i class="fa fa-line-chart"></i>',
                Url::toRoute(['produto/avaliacaoproduto', 'idproduto'=>$model->idProduto]),
                [
                'title' => Yii::t('app', 'Avaliar Produto'),
                ]);
        }
        ],

        ],
        ],
        ]); ?>

    </div>
