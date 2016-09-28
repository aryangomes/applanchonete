<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelRelatorio app\models\Relatorio */
/* @var $tiposRelatorio array */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Relatorio',
	]) . ' ' . $modelRelatorio->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relatorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelRelatorio->nome, 'url' => ['view', 'id' => $modelRelatorio->idrelatorio]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="relatorio-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'modelRelatorio' => $modelRelatorio,
		'tiposRelatorio'=>$tiposRelatorio,
		]) ?>

	</div>
