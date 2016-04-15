<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProdutoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Produtos de Venda');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model'=>'Produto de Venda']), ['produto/cadastrarprodutovenda'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

     //   'idProduto',
        'nome',
        'valorVenda',
        //'isInsumo',
        //'quantidadeMinima',
            // 'idCategoria',
            // 'quantidadeEstoque',

        ['class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {alterarprodutovenda} {delete} {avaliarproduto}',
        'buttons' => [
        'alterarprodutovenda' => function ($url, $model) {
            return $model->isInsumo ?'' : Html::a('<i class="fa fa-pencil-square-o"></i>',
                Url::toRoute(['produto/alterarprodutovenda', 'idprodutoVenda'=>$model->idProduto]),
                [
                'title' => Yii::t('app', 'Alterar Insumos do Produto Venda'),
                ]);
        },
        'avaliarproduto' => function ($url, $model) {
            return $model->isInsumo ?'' : Html::a('<i class="fa fa-line-chart"></i>',
                Url::toRoute(['produto/avaliacaoproduto', 'idproduto'=>$model->idProduto]),
                [
                'title' => Yii::t('app', 'Avaliar Produto'),
                ]);
        },
        
        ],

        ],
        ],
        ]); ?>

    </div>
