<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 * @var amnah\yii2\user\models\Role $role
 * @var yii\widgets\ActiveForm $form
 */

$module = $this->context->module;
$role = $module->model("Role");

?>

<div class="user-form">
    <?php //var_dump($permissoesUser) ?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($user, 'newPassword')->passwordInput() ?>

    <?= $form->field($profile, 'full_name'); ?>

    <?php // $form->field($user, 'role_id')->dropDownList($permissoes); ?>

    <?php 
    $inic = array();
    if (isset($permissoesUser)) {

        foreach ($permissoesUser as $key => $value) {
            array_push($inic, $key);
        }
    }
    ?>

    <?php /*$form->field($user, 'role_id')->widget(Select2::classname(), [

        'data' => $permissoes,

        //'attribute'=>$permissoesUser,
        'value'=>$inic,
      //  'options' => ['placeholder' => 'Selecione as permissões'],
        'pluginOptions' => [

        'allowClear' => true,
        'multiple'=>true,
        ],
        ]); */ ?>

<?php
echo Html::label('Permissões');

echo Select2::widget([
    'name'=>'roles',

    'data' => $permissoes,

    'attribute'=>'roles',
    'value'=>$inic,
      //  'options' => ['placeholder' => 'Selecione as permissões'],
    'pluginOptions' => [

    'allowClear' => true,
    'multiple'=>true,
    ],
    ]);

echo "</br>";
?>

<?= $form->field($user, 'status')->dropDownList($user::statusDropdown()); ?>

<?php // use checkbox for banned_at ?>
<?php // convert `banned_at` to int so that the checkbox gets set properly ?>
<?php $user->banned_at = $user->banned_at ? 1 : 0 ?>
<?= Html::activeLabel($user, 'banned_at', ['label' => Yii::t('user', 'Banned')]); ?>
<?= Html::activeCheckbox($user, 'banned_at'); ?>
<?= Html::error($user, 'banned_at'); ?>

<?= $form->field($user, 'banned_reason'); ?>

<div class="form-group">
    <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
