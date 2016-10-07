<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelPedido app\models\Pedido */
/* @var $situacaopedido array */
/* @var $mensagem mixed */
/* @var $produtosVenda mixed */
/* @var $itemPedido \app\models\Itempedido */
/* @var $formasPagamento array */
/* @var $mesa array */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Pedido ',
        ]) . $modelPedido->idPedido;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelPedido->idPedido, 'url' => ['view', 'id' => $modelPedido->idPedido]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pedido-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'modelPedido' => $modelPedido,
        'situacaopedido' => $situacaopedido,
        'produtosVenda' => $produtosVenda,
        'itemPedido' => $itemPedido,
        'formasPagamento' => $formasPagamento,
        'mensagem' => $mensagem,
        'mesa' => $mesa,
    ])
    ?>

</div>
