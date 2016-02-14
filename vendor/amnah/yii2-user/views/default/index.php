<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\Module $module
 * @var array $actions
 */

$module = $this->context->module;

$this->title = Yii::t('user', 'Yii 2 User');
?>
<?php 
if (isset($actions)) {

   ?>
   <div class="user-default-index">

    <h1>Yii 2 User Module - <?= $module->getVersion(); ?></h1>
    <h3>Actions in this module</h3>

    <p>
        <em><strong>Note:</strong> Some actions may be unavailable depending on if you are logged in/out, or as an
            admin/regular user</em>
        </p>

        <table class="table table-bordered">
            <tr>
                <th>URL</th>
                <th>Description</th>
            </tr>

            <?php foreach ($actions as $url => $description): ?>

            <tr>
                <td>
                    <strong><?= Html::a($url, [$url]) ?></strong>
                </td>
                <td>
                    <?= $description ?>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

</div>
<?php }

else{
    ?>
    <div class="user-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(Yii::t('app', 'Create User'), ['admin/create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'role_id',
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

            ['class' => 'yii\grid\ActionColumn',

            'header'=>'Ações',
            'template' => ' {view}  {update} {delete} ',
            'buttons' => [



            'view' => function ($url, $model) {

                return isset($model->id) ? 
                Html::a("<span class='glyphicon glyphicon-eye-open'></span>", 
                    Url::toRoute(['admin/view', 'id'=>$model->id]), [
                    'title' => Yii::t('yii', 'View'),

                    ]) : '';
            },


            'update' => function ($url, $model) {

                return isset($model->id) ? 
                Html::a("<span class='glyphicon glyphicon-pencil'></span>", 
                    Url::toRoute(['admin/update', 'id'=>$model->id]), [
                    'title' => Yii::t('yii', 'Update'),

                    ]) : '';
            },

            'delete' => function ($url, $model) {

                return isset($model->id) ? 
                Html::a("<span class='glyphicon glyphicon-trash'></span>", 
                    Url::toRoute(['admin/delete', 'id'=>$model->id]), [
                    'title' => Yii::t('yii', 'Delete'),

                    'data-method'=>'post']) : '';
            },
            ],
            ],
            ],
            ]); ?>

        </div>

        <?php


    }?>