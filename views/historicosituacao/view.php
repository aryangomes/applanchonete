<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Historicosituacao */

$this->title = $model->idPedido;
$this->params['breadcrumbs'][] = ['label' => 'Historicosituacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historicosituacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idPedido' => $model->idPedido, 'idSituacaoPedido' => $model->idSituacaoPedido], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idPedido' => $model->idPedido, 'idSituacaoPedido' => $model->idSituacaoPedido], [
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
            'idSituacaoPedido',
            'dataHora',
        ],
    ]) ?>

</div>
