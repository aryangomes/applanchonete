<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Historicosituacao */

$this->title = 'Situação do Pedido de '.
    Yii::$app->formatter->asDate($model->dataHora, 'dd/M/Y à\s HH:m');
$this->params['breadcrumbs'][] = ['label' => 'Histórico de Situações do Pedido', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historicosituacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'idPedido' => $model->idPedido, 'idSituacaoPedido' => $model->idSituacaoPedido], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'idPedido' => $model->idPedido, 'idSituacaoPedido' => $model->idSituacaoPedido], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idPedido',
            'situacaoPedido.titulo',
            [
                'attribute'=>'dataHora',
                'value'=> Yii::$app->formatter->asDate($model->dataHora, 'dd/M/Y à\s HH:m'),
            ],
        ],
    ]) ?>

</div>
