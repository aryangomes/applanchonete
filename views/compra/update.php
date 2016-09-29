<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelCompra app\models\Compra */
/* @var $compraProduto app\models\Compra */
/* @var $produtos array */
/* @var $mensagem mixed */
/* @var $produtosDaCompras array */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Compra do dia ',
    ]) . date("d/m/Y",strtotime($modelCompra->dataCompra));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Compra do dia '. date("d/m/Y",strtotime($modelCompra->dataCompra)), 'url' => ['view', 'id' => $modelCompra->idconta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="compra-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelCompra' => $modelCompra,
        'compraProduto' => $compraProduto,
        'produtos' => $produtos,
        'produtosDaCompras' => $produtosDaCompras,
        'mensagem' => $mensagem,

    ]) ?>

</div>
