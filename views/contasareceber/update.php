<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelContasareceber app\models\Contasareceber */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Conta a receber ',
	]) . $modelContasareceber->conta->descricao;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Conta a receber'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelContasareceber->conta->descricao, 'url' => ['view', 'id' => $modelContasareceber->idconta]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="contasareceber-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'modelContasareceber' => $modelContasareceber,
		'contas'=>$contas,
		]) ?>

	</div>
