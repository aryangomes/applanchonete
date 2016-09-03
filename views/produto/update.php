<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Produto */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
		'modelClass' => 'Produto',
	]) . ' ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>'Produto '.$model->nome, 'url' => ['view', 'id' => $model->idProduto]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="produto-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php
	if(!$model->isInsumo) {
		echo $this->render('_form', [
			'model' => $model,
			'models' => $models,
			'categorias' => $categorias,
			'insumos' => $insumos,
			'insumo' => $insumo,
			'modelProdutoVenda' => $modelProdutoVenda,

			'idprodutoVenda' => $idprodutoVenda,
			'mensagem'=> $mensagem,
		]);

	}else{
		echo $this->render('_form', [
			'model' => $model,

			'categorias' => $categorias,
			'mensagem'=> $mensagem,

		]);
	}
	?>

</div>
