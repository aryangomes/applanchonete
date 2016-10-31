<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PagamentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pagamentos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pagamento-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>

        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Pagamento']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'idConta',
            'idPedido',
            [
                'attribute' => 'formapagamentoIdTipoPagamento',
                'label'=>'Forma de Pagamento',
                'value' => function ($modelPagamento) {
                    return isset($modelPagamento->formapagamento_idTipoPagamento) &&
                            ($modelPagamento->formapagamento_idTipoPagamento > 0) ?
                            $modelPagamento->formapagamentoIdTipoPagamento->titulo : null;
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'header' => 'Ação',
                'buttons' => [
                    'view' => function ($url, $modelPagamento) {
                        return Html::a('Clique aqui para visualizar detalhes do pedido <i class="fa fa-search-plus"></i>',
                            \yii\helpers\Url::toRoute(['view', 'idConta' => $modelPagamento->idConta, 'idPedido'=>
                                $modelPagamento->idPedido]),
                            [
                                'title' => Yii::t('app', 'Clique aqui para visualizar detalhes do pedido'),
                            ]);
                    }
                ],

            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>


<?php
if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>