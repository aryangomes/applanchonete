<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Contasareceber */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Conta a receber ',
	]) . $model->conta->descricao;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Conta a receber'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->conta->descricao, 'url' => ['view', 'id' => $model->idconta]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="contasareceber-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'contas'=>$contas,
		]) ?>

	</div>
