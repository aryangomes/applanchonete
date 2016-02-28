<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
       // 'role_id',
        'status',
        'email:email',
        'username',
            // 'password',
            // 'auth_key',
            // 'access_token',
            // 'logged_in_ip',
            // 'logged_in_at',
            // 'created_ip',
            // 'created_at',
            // 'updated_at',
            // 'banned_at',
            // 'banned_reason',

        ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>

    </div>
