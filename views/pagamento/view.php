<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pagamento */

$this->title = $model->idConta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pagamento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'idConta' => $model->idConta, 'idPedido' => $model->idPedido], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Delete'), ['delete', 'idConta' => $model->idConta, 'idPedido' => $model->idPedido], [
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
        'model' => $model,
        'attributes' => [
            'idConta',
            'idPedido',
            [
                'attribute' => 'formapagamentoIdTipoPagamento',
                'label'=>'Forma de Pagamento',
                'value' => isset($model->formapagamento_idTipoPagamento) &&
                ($model->formapagamento_idTipoPagamento > 0) ?
                        $model->formapagamentoIdTipoPagamento->titulo : null
            ],
        ],
    ])
    ?>

</div>
