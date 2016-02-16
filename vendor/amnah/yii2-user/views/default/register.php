<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\sortinput\SortableInput;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\User $profile
 * @var string $userDisplayName
 */

$module = $this->context->module;

$this->title = Yii::t('user', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-register">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php if ($flash = Yii::$app->session->getFlash("Register-success")): ?>

  <div class="alert alert-success">
    <p><?= $flash ?></p>
  </div>

<?php else: ?>

  <?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
    'labelOptions' => ['class' => 'col-lg-2 control-label'],
    ],
    'enableAjaxValidation' => true,
    ]); ?>

    <?php if ($module->requireEmail): ?>
    <?= $form->field($user, 'email') ?>
  <?php endif; ?>

  <?php if ($module->requireUsername): ?>
  <?= $form->field($user, 'username') ?>
<?php endif; ?>

<?= $form->field($user, 'newPassword')->passwordInput() ?>


<?php // $form->field($user, 'role_id')->dropDownList($permissoes, ['prompt'=>'Escolha o tipo de usuário'])  ?>


<?php

 // $form->field($user, 'role_id')->checkboxList($permissoes)  ?>

 <?php /* echo $form->field($user, 'role_id')->widget(Select2::classname(), [
  'data' => $permissoes,
  'size'=>'lg',

  'options' => ['placeholder' => 'Selecione as permissões'],
  'pluginOptions' => [
  'allowClear' => true,
  'multiple'=>true,

  ],
  'pluginEvents'=>[
  "select2:select" => "function() {
   /*
   console.log('select');
   var elements = [];
   $(document).ready(function(){




    var foo = []; 



    $('#user-role_id :selected').each(function(i, selected){ 

      foo[i] = $(selected).val(); 
      console.log( 'foo[i]: ' +  foo[i]);
      console.log( 'i: ' +  i);
      console.log( 'selected: ' +  $(selected).val());
    });

console.log( foo.length);


var opcaoselecionada ;
opcaoselecionada =foo[(foo.length - 1)];



console.log('opcaoselecionada: ' + opcaoselecionada);




switch(opcaoselecionada) {
  case 'despesa':

  if ( $(\" [value='despesa']\" ).is(':selected')) {
   console.log('despesa cliked1');
   $(\" [value='create-despesa']\" ).prop('selected',true);
   $(\" [value='index-despesa']\" ).prop('selected',true);
   $(\" [value='update-despesa']\" ).prop('selected',true);
   $(\" [value='delete-despesa']\" ).prop('selected',true);

 }
 else{
  console.log('despesa cliked2');
  $(\" [value='create-despesa']\" ).prop('selected',false);
  $(\" [value='index-despesa']\" ).prop('selected',false);
  $(\" [value='update-despesa']\" ).prop('selected',false);
  $(\" [value='delete-despesa']\" ).prop('selected',false);
}
break;
case 'fornecedor':
console.log('fornecedor cliked1');
if ( $([value='fornecedor']).is(':selected')) {
  $([value='create-fornecedor']).prop('selected',true);
  $([value='index-fornecedor']).prop('selected',true);
  $([value='update-fornecedor']).prop('selected',true);
  $([value='delete-fornecedor']).prop('selected',true);

}
else{

  $([value='create-fornecedor']).prop('selected',false);
  $([value='index-fornecedor']).prop('selected',false);
  $([value='update-v']).prop('selected',false);
  $([value='delete-fornecedor']).prop('selected',false);
}
break;
default:
break;
}
});

}",

],
]); */ ?>

<?php 
for ($i=0; $i < count($permissoes) ; $i++) { 



  echo SortableInput::widget([
    'name'=>'kv-conn-1',
    'items' => $permissoes[$i],
    'hideInput' => true,
    'sortableOptions' => [
    'connected'=>true,
    ],
    'options' => ['class'=>'form-control', 'readonly'=>true]
    ]);
  echo '</div>';
  echo '<div class="col-sm-6">';
  echo SortableInput::widget([
    'name'=>'User[role_id]',
    'items' => [
    ],
    'hideInput' => true,
    'sortableOptions' => [
    'itemOptions'=>['class'=>'alert alert-warning'],
    'connected'=>true,
    ],
    'options' => ['class'=>'form-control', 'readonly'=>true, 'placeholder'=>'Arraste para cá']
    ]);
}

?>

<?php /* uncomment if you want to add profile fields here
<?= $form->field($profile, 'full_name') ?>
        */ ?>

        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <?= Html::submitButton(Yii::t('user', 'Register'), ['class' => 'btn btn-primary']) ?>

            <br/><br/>
            <?= Html::a(Yii::t('user', 'Login'), ["/user/login"]) ?>
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

      <?php endif; ?>

    </div>