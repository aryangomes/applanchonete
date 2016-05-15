<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Itempedido */

$this->title = Yii::t('app', 'Create {model}',['model'=>'Item pedido']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item pedido'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itempedido-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'produtosvenda'=>$produtosvenda,
		'pedidos'=>$pedidos,
		]) ?>

	</div>
