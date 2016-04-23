<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Itempedido */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Itempedido',
	]) . $model->idPedido;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Itempedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPedido, 'url' => ['view', 'idPedido' => $model->idPedido, 'idProduto' => $model->idProduto]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="itempedido-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		
		]) ?>

	</div>
