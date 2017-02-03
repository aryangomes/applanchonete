<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Historicosituacao */

$this->title = 'Update Historicosituacao: ' . ' ' . $model->idPedido;
$this->params['breadcrumbs'][] = ['label' => 'Histórico de Situações do Pedido', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPedido, 'url' => ['view', 'idPedido' => $model->idPedido, 'idSituacaoPedido' => $model->idSituacaoPedido]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="historicosituacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
