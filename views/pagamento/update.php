<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelPagamento app\models\Pagamento */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Pagamento',
]) .' '. $modelPagamento->idConta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelPagamento->idConta, 'url' => ['view', 'idConta' => $modelPagamento->idConta, 'idPedido' => $modelPagamento->idPedido]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pagamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelPagamento' => $modelPagamento,
    ]) ?>

</div>
