<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InsumosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Create {model}', ['model' => 'Insumo']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Insumos'), 'url' => ['index']];
?>
<div class="insumos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Insumo']), ['produto/create'], ['class' => 'btn btn-success',
            'title'=>'Clique aqui para cadastrar um novo Insumo']) ?>
    </p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => [
                //   ['class' => 'yii\grid\SerialColumn'],

                //'idprodutoVenda',
                [
                    'attribute' => 'nomeInsumo',
                    'format' => 'raw',
                    'value' => function ($model) {

                        return Html::a($model->nomeInsumo, ['view',
                            'idprodutoVenda' => $model->idprodutoVenda,
                            'idprodutoInsumo' => $model->idprodutoInsumo]);
                    },
                ],
                [
                    'label' => 'Produto de Venda',
                    'value' => 'nomeprodutovenda',
                ],
                [
                    'label' => 'Quantidade',
                    'value' => function ($model) {
                        return $model->quantidade . ' ' . $model->unidade;
                    },
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