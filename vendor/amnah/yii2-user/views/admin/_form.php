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


        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'email')->textInput(['maxlength' => 255,
        'placeholder'=>'Digite o email do usuário']) ?>

        <?= $form->field($user, 'username')->textInput(['maxlength' => 255,
            'placeholder'=>'Digite o usuário']) ?>

        <?= $form->field($user, 'newPassword')->passwordInput([
            'placeholder'=>'Digite a senha do usuário']) ?>

        <?= $form->field($profile, 'full_name')->textInput([
            'placeholder'=>'Digite o nome completo do usuário']); ?>



        <?= $form->field($authAssignment, 'item_name')->widget(Select2::classname(), [

            'data' => $permissoes,
            'options'=>[
                'id'=>'permissoes',
                'prompt'=>'Selecione a(s) permissão(ões)',
            ],
            'pluginOptions' => [

//                'allowClear' => true,
                'multiple' => true,

            ],
        ]); ?>



        <?php
            $this->registerJsFile(\Yii::getAlias('@web') . "/js/user_form.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
        ?>

        <div class="form-group">
            <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


<?php

if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>