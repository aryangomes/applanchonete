<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Pedido',
	]) . $model->idPedido;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPedido, 'url' => ['view', 'id' => $model->idPedido]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pedido-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'situacaopedido' => $situacaopedido,
        'produtosVenda' => $produtosVenda,
        'itemPedido' => $itemPedido,
		]) ?>

	</div>
