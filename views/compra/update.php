<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Compra */
$formatter = \Yii::$app->formatter;
$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Compra',
	]) . ' ' . $formatter->asDate($model->dataCompra, 'dd/MM/yyyy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $formatter->asDate($model->dataCompra, 'dd/MM/yyyy'), 'url' => ['view', 'id' => $model->idconta]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="compra-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		
		]) ?>

	</div>
