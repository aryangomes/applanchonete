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
            <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Produto']), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],


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

                            return !$modelProduto->isInsumo ? 'R$ ' .
                                number_format($modelProduto->valorVenda, 2) : null;
                        }
                    ],
                    [
                        'attribute' => 'isInsumo',
                        'format' => 'text',
                        'value' => function ($modelProduto) {

                            return $modelProduto->isInsumo ? 'Sim' : 'Não';
                        }
                    ],
                    [
                        'attribute' => 'quantidadeEstoque',
                        'format' => 'text',

                        'value' => function ($modelProduto) {

                            return $modelProduto->isInsumo ? $modelProduto->quantidadeEstoque : null;
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>


<?php
if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>