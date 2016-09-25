<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 */
/* @var $permissoesUser array */
/* @var $permissoes array */
/* @var $authAssignment \app\models\AuthAssignment */
/* @var $mensagem mixed */
$this->title = Yii::t('user', 'Update {modelClass}: ', [
	'modelClass' => 'Usuário',
	]) . ' ' . $user->email;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = Yii::t('user', 'Update');
?>
<div class="user-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'user' => $user,
		'profile' => $profile,
		'permissoes'=>$permissoes,
		'permissoesUser'=>$permissoesUser,
        'authAssignment'=>$authAssignment,
		'mensagem'=>$mensagem,
		]) ?>

	</div>
