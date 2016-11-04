<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PedidoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider
 * @var $situacaoDoPedido int
 * @var $situacaopedido array*/

$this->title = Yii::t('app', 'Pedidos');
$this->params['breadcrumbs'][] = $this->title;
//date_default_timezone_set('America/Sao_Paulo');
?>
<div class="pedido-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Pedido']), ['create'], ['class' => 'btn btn-success',
            'title'=>'Clique aqui para cadastrar um novo Pedido']) ?>
    </p>
    <div class="form-group">
        <?= Html::label('Situação do Pedido') ?>
        <?php $form = \yii\widgets\ActiveForm::begin(['action' => 'index', 'id' => $situacaoDoPedido, 'method' => 'get',]); ?>
        <?= Html::dropDownList('situacao-pedido', $situacaoDoPedido, $situacaopedido, ['class' => 'form-control']) ?>
        <?php $form = \yii\widgets\ActiveForm::end(); ?>
    </div>
    <?php
    $this->registerJs('$("select").change(function(){$(this).submit()});');
    ?>

    <div class="table-responsive">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                [
                    'attribute' => 'situacaopedido',
                    'format' => 'raw',
                    'label'=>'Situação do Pedido',
                    'value' => function ($modelPedido) {

                        return Html::a($modelPedido->situacaopedido->titulo, ['view',
                            'id' => $modelPedido->idPedido]);
                    }
                ],
                [
                    'attribute' => 'totalPedido',
                    'value' => function ($modelPedido) {
                        return 'R$ ' . $modelPedido->totalPedido;
                    }
                ],
                [
                    'label' => 'Itens do Pedido (Produto/Quantidade)',
                    'value' => function ($modelPedido) {
                        $itensPedidos = $modelPedido->getItensPedido();
                        $results = [];
                        for ($i = 0; $i < count($itensPedidos); $i++) {
                            $str = $itensPedidos[$i][0] . '(' . $itensPedidos[$i][1] . ')';
                            array_push($results, $str);
                        }
                        return (implode(", ", $results));

                    }
                ],
               
                ['attribute' => 'idMesa',
                    'label' => 'Mesa',
                    'value' => 'idMesa'],

                [
                    'attribute' => 'historicosituacaos.dataHora',
                    'value' => function ($modelPedido) {


                        return
                            ($modelPedido->getDataHoraPedido() != null) ?
                                date("d/m/Y H:i",
                                    strtotime($modelPedido->getDataHoraPedido())) : null;
                    }
                ],
                [
                    'attribute' => 'historicosituacaos.user.username',
                    'label'=>'Registrado por',
                    'value' => function ($modelPedido) {

                        return isset($modelPedido->historicosituacaos->user->username)?
                            $modelPedido->historicosituacaos->user->username : null;
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],


            ],
        ]); ?>
        <?php Pjax::end(); ?>

    </div>
</div>


<?php
if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>