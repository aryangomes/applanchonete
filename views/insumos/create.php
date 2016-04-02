<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Insumos */

$this->title = Yii::t('app', 'Create Insumos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Insumos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="insumos-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'insumos' => $insumos,
		'produtosvenda' => $produtosvenda,
		]) ?>

	</div>
