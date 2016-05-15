<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contasapagar */

$this->title = Yii::t('app', 'Create {model}',['model'=>'Conta a pagar']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contas a pagar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contasapagar-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'contas'=>$contas,
		]) ?>

	</div>
