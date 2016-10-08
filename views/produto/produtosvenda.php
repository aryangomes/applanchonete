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


    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //   'idProduto',
                [
                    'attribute' => 'nome',
                    'format' => 'raw',
                    'value' => function ($modelProduto) {

                        return Html::a($modelProduto->nome, ['view', 'id' => $modelProduto->idProduto]);
                    }
                ],
                [
                    'attribute' => 'valorVenda',
                    'format' => 'text',
                    'value' => function ($modelProduto) {
                        return 'R$ ' . number_format($modelProduto->valorVenda, 2);
                    }
                ],


                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>