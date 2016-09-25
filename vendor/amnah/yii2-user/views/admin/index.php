<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\AuthItem;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\search\UserSearch $searchModel
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Role $role
 */

$module = $this->context->module;
$user = $module->model("User");
$role = $module->model("Role");

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Usuário']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <?php \yii\widgets\Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

//                'id',
                'profile.full_name',
                'email:email',
                [
                    'attribute' => 'status',
                    'label' => Yii::t('user', 'Status'),
                    'filter' => $user::statusDropdown(),
                    'value' => function ($model, $index, $dataColumn) use ($user) {

                       /* $statusDropdown = $user::statusDropdown();
                        return $statusDropdown[$model->status];*/
                       return $model->status ? 'Ativo':'Não ativo';
                    },
                ],


                [
                    'attribute' => 'role_id',
                    'label' => 'Permissões',

                    'value' => function ($data) {
                        return $data->permissoes;

                    }
                ],
                'created_at:datetime',

                // 'username',
                // 'password',
                // 'auth_key',
                // 'access_token',
                // 'logged_in_ip',
                // 'logged_in_at',
                // 'created_ip',
                // 'updated_at',
                // 'banned_at',
                // 'banned_reason',

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'header' => 'Ação',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('Clique aqui para visualizar detalhes do usuário<i class="fa fa-search-plus"></i>',
                                \yii\helpers\Url::toRoute(['view', 'id' => $model->id]),
                                [
                                    'title' => Yii::t('app', 'Clique aqui para visualizar detalhes do usuário'),
                                ]);
                        }
                    ],

                ],
            ],
        ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>

    </div>
</div>