<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Compra',
	]) . ' ' . $model->datacompra;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->datacompra, 'url' => ['view', 'id' => $model->idcompra]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="compra-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'fornecedores'=>$fornecedores,
		]) ?>

	</div>
