<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelPagamento app\models\Pagamento */

$this->title = $modelPagamento->idConta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pagamento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'idConta' => $modelPagamento->idConta, 'idPedido' => $modelPagamento->idPedido], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Delete'), ['delete', 'idConta' => $modelPagamento->idConta, 'idPedido' => $modelPagamento->idPedido], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $modelPagamento,
        'attributes' => [
            'idConta',
            'idPedido',
            [
                'attribute' => 'formapagamentoIdTipoPagamento',
                'label'=>'Forma de Pagamento',
                'value' => isset($modelPagamento->formapagamento_idTipoPagamento) &&
                ($modelPagamento->formapagamento_idTipoPagamento > 0) ?
                        $modelPagamento->formapagamentoIdTipoPagamento->titulo : null
            ],
        ],
    ])
    ?>

</div>
