<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelCategoria app\models\Categoria */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Categoria',
	]) . ' ' .$modelCategoria->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelCategoria->nome, 'url' => ['view', 'id' => $modelCategoria->idCategoria]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="categoria-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'modelCategoria' => $modelCategoria,
		]) ?>

	</div>
