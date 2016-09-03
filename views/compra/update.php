<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Compra do dia ',
    ]) . $model->dataCompra;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dataCompra, 'url' => ['view', 'id' => $model->idconta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="compra-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'compraProduto' => $compraProduto,
        'produtos' => $produtos,
        'produtosDaCompras' => $produtosDaCompras,
        'mensagem' => $mensagem,

    ]) ?>

</div>
