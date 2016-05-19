<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Insumo */

$this->title = Yii::t('app', 'Create {model}', ['model'=>'Produto Venda']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos de Venda'), 'url' => ['/produto/produtosvenda']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="produto-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_formprodutovenda', [
		'model' => $model,
		'insumos' => $insumos,
		'produtosvenda' => $produtosvenda,
		'idProdutoVenda'=>$idProdutoVenda,
		'action'=>'create',
		
		]) ?>

	</div>
