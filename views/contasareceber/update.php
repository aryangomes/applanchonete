<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelContasareceber app\models\Contasareceber */

$descricao = isset($modelContasareceber->conta->descricao)?
	$modelContasareceber->conta->descricao:
	"Conta sem descrição";

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Conta a receber ',
	]) . $descricao;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Conta a receber'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $descricao, 'url' => ['view', 'id' => $modelContasareceber->idconta]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="contasareceber-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'modelContasareceber' => $modelContasareceber,
		'contas'=>$contas,
		]) ?>

	</div>
