<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelContasapagar app\models\Contasapagar */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
	'modelClass' => 'Conta a pagar',
	]) . ' '.$modelContasapagar->conta->descricao;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contas a pagar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelContasapagar->conta->descricao, 'url' => ['view', 'id' => $modelContasapagar->idconta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="contasapagar-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'modelContasapagar' => $modelContasapagar,
		'contas'=>$contas,
		]) ?>

	</div>
