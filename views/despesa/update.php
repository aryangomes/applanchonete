<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Despesa */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Despesa',
	]) . ' ' . $model->iddespesa;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Despesas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomedespesa, 'url' => ['view', 'id' => $model->iddespesa]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="despesa-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		]) ?>

	</div>
