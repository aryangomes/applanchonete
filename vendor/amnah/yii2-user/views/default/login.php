<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\models\forms\LoginForm $model
 */

$this->title = Yii::t('user', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row text-center">
    <div class="col-md-4">
    &nbsp;
    </div>
    <div class="col-md-4">
    <?=  Html::img('../sgl.png',
            ['class' => 'img-responsive',
              ]) ?>
    </div>
    <div class="col-md-4">
    &nbsp;
    </div>
</div>
<div class="row text-center">
    <div class="col-lg-3">
        &nbsp;
    </div>
    <div class="col-lg-6">
        <h2>Sistema de Gerência de Lanchonete</h2>
    </div>
    <div class="col-lg-3">
        &nbsp;
    </div>
</div>
<div class="user-default-login">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>





    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-lg-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],

    ]); ?>

    <?= $form->field($model, 'username')->textInput(['placeholder'=>'Digite o E-mail / Usuário']) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Digite a senha']) ?>


    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-primary']) ?>

            <br/><br/>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (Yii::$app->get("authClientCollection", false)): ?>
        <div class="col-lg-offset-2 col-lg-10">
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['/user/auth/login']
            ]) ?>
        </div>
    <?php endif; ?>

    <div class="col-lg-offset-2" style="color:#999;">

        <!-- To modify the username/password, log in first and then --> <?php /* echo HTML::a("update your account", ["/user/account"])  */ ?>
        .
    </div>

</div>
<script>
    document.getElementById("loginform-username").focus();
</script>