<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Insumos */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'insumo',
	]) . ' ' . $model->nomeInsumo . ' no Produto Venda ' . $model->nomeProdutoVenda;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Insumos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomeInsumo, 'url' => ['view', 'idprodutoVenda' => $model->idprodutoVenda,
'idprodutoInsumo' => $model->idprodutoInsumo]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="insumos-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'insumos' => $insumos,
		'produtosvenda' => $produtosvenda,
		
		]) ?>

	</div>
