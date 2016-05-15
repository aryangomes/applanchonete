<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contasareceber */

$this->title = Yii::t('app', 'Create Conta a receber');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Conta a receber'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contasareceber-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'contas'=>$contas,
		]) ?>

	</div>
