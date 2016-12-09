<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */

$this->title = $user->email;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('user', 'Update'), ['update', 'id' => $user->id], ['class' => 'btn btn-primary',
            'title'=>'Clique para ir para a tela de alteração dos dados do Usuário']) ?>
        <?= Html::a(Yii::t('user', 'Delete'), ['delete', 'id' => $user->id], [
            'class' => 'btn btn-danger',
            'title' => 'Clique para apagar esse Usuário',
            'data' => [
                'confirm' => Yii::t('user', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            'id',
            // 'role_id',
            'profile.full_name',
            'email:email',
            'username',
            [
                // 'attribute'=>'gender',
                'format' => 'text',
                'label' => 'Permissões',
                'value' =>
                    ($user->permissoes),

            ],

            [
                'attribute' => 'status',
                'value' => $user->status ? 'Ativo' : 'Não ativo',
            ],

            [

                'attribute' => 'created_at',

                'value' =>isset($user->created_at) ?
                        Yii::$app->formatter->asDate($user->created_at, 'dd/M/Y à\s H:i:s'):null
            ],

            [

                'attribute' => 'updated_at',

                'value' =>isset($user->updated_at) ?
                    Yii::$app->formatter->asDate($user->updated_at, 'dd/M/Y à\s H:i:s'):null
            ],

//            'password',
//            'auth_key',
//            'access_token',
//            'logged_in_ip',
//            'logged_in_at',
//            'created_ip',
//            'created_at',
//            'updated_at',
//            'banned_at',
//            'banned_reason',
        ],
    ]) ?>

</div>
