<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Produto */

$this->title = Yii::t('app', 'Create {model}', ['model'=>'Produto']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<script src="/applanchonete/web/admin/js/jquery.js"></script>
<div class="produto-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'categorias' => $categorias,
        'insumos'=>$insumos,
        'insumo'=>$insumo,
		]) ?>

	</div>
