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
        <?= Html::a(Yii::t('app', 'Create Pagamento'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'value' => function ($model) {
                    return isset($model->formapagamento_idTipoPagamento) &&
                            ($model->formapagamento_idTipoPagamento > 0) ?
                            $model->formapagamentoIdTipoPagamento->titulo : null;
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>
