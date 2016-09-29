<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelPedido app\models\Pedido */
/* @var $mensagem mixed */
/* @var $situacaopedido array */
/* @var $produtosVenda mixed */
/* @var $itemPedido \app\models\Itempedido */
/* @var $formasPagamento array */

$this->title = Yii::t('app', 'Create {model}', ['model' => 'Pedido']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pedido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'modelPedido' => $modelPedido,
        'situacaopedido' => $situacaopedido,
        'produtosVenda' => $produtosVenda,
        'itemPedido' => $itemPedido,
        'formasPagamento' => $formasPagamento,
        'mensagem' => $mensagem,
    ])
    ?>

</div>
