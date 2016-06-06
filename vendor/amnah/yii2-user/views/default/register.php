<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\sortinput\SortableInput;
use yii\helpers\BaseHtml;

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
<?= Html::jsFile("/applanchonete/web/admin/js/jquery.js") ?>
<?= Html::jsFile("/applanchonete/web/admin/js/bootstrap.js") ?>


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

</div>
<div class="linha">
    <div class="user-default-register">
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
]); */


        ?>

        <?php
        for ($i = 0; $i < count($permissoes); $i++) {

            // foreach ($permissoes as $p) {
            ?>
            <div class="col-sm-6">
                <div id="<?= 'cb-' . $macroauthitems[$i] ?>">
                    <?= $form->field($user, 'role_id')->checkboxList($permissoes[$i]
                        , ['itemOptions' => ['id' => $macroauthitems[$i]]])
                        ->label($macroauthitems[$i]);
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="col-sm-6">
            <?php


            echo Html::label('Permissões')
                . '</br>';
            echo SortableInput::widget([
                'name' => 'User[role_id]',
                'options' => ['style' => 'height: 1000px'],

                'items' => [
                ],

                'hideInput' => true,
                'sortableOptions' => [
                    'itemOptions' => ['class' => 'alert alert-warning'],
                    'connected' => true,
                    'pluginOptions' => [
                        'dropOnEmpty' => true,
                    ],
                    'pluginEvents' => [
                        'sortstart' => "function() { 
    console.log('sortstart'); 
  }",
                        'sortstop' => "function() { 
    console.log('sortstop'); 
  }",
                        'sortupdate' => "

  function(e, ui) {
  
    console.log('e.data:' + e.data); 
    console.log('e.type: ' + e.type); 
    if (ui.item.data().name == 'despesa') {
     var arraydespesavalues = ['index-despesa','view-despesa',
     'create-despesa','update-despesa','delete-despesa'];
     var arraydespesatext = ['Listar','Visualizar','Criar','Editar','Deletar'];

     var aux = [];
     var auxtext = [];
     for (i = 0; i < arraydespesavalues.length; i++) { 
      if (arrayvalues.indexOf(arraydespesavalues[i]) < 0) {

        aux.push(arraydespesavalues[i]);
        auxtext.push(arraydespesatext[i]);
        
      }
    }
    for (i = 0; i < aux.length; i++) { 
     arrayvalues.push(aux[i]);
   }

   $(\"[data-name=\'despesa\']\").text('Despesa (Listar, Visualizar, Criar, Editar, Deletar)');

   $('input[name=\"User[role_id]\"]').val(arrayuservalues);

   $('li').filter('[data-name=\"index-despesa\"]').remove();
   $('li').filter('[data-name=\"view-despesa\"]').remove();
   $('li').filter('[data-name=\"create-despesa\"]').remove();
   $('li').filter('[data-name=\"update-despesa\"]').remove();
   $('li').filter('[data-name=\"delete-despesa\"]').remove();
   $('#despesa-sortable li').remove();
 }
 else if (ui.item.data().name == 'caixa') {
   var arraycaixavalues = ['index-caixa','view-caixa',
   'create-caixa','update-caixa','delete-caixa'];
   var arraycaixatext = ['Listar','Visualizar','Criar','Editar','Deletar'];

   var aux = [];
   var auxtext = [];
   for (i = 0; i < arraycaixavalues.length; i++) { 
    if (arrayvalues.indexOf(arraycaixavalues[i]) < 0) {

      aux.push(arraycaixavalues[i]);
      auxtext.push(arraycaixatext[i]);
      
    }
  }
  for (i = 0; i < aux.length; i++) { 
   arrayvalues.push(aux[i]);
 }

 $(\"[data-name=\'caixa\']\").text('Caixa (Listar, Visualizar, Criar, Editar, Deletar)');

 $('input[name=\"User[role_id]\"]').val(arrayuservalues);

 $('li').filter('[data-name=\"index-caixa\"]').remove();
 $('li').filter('[data-name=\"view-caixa\"]').remove();
 $('li').filter('[data-name=\"create-caixa\"]').remove();
 $('li').filter('[data-name=\"update-caixa\"]').remove();
 $('li').filter('[data-name=\"delete-caixa\"]').remove();
 $('#caixa-sortable li').remove();
}

else if (ui.item.data().name == 'compra') {
 var arraycompravalues = ['index-compra','view-compra',
 'create-compra','update-compra','delete-compra'];
 var arraycompratext = ['Listar','Visualizar','Criar','Editar','Deletar'];

 var aux = [];
 var auxtext = [];
 for (i = 0; i < arraycompravalues.length; i++) { 
  if (arrayvalues.indexOf(arraycompravalues[i]) < 0) {

    aux.push(arraycompravalues[i]);
    auxtext.push(arraycompratext[i]);
    
  }
}
for (i = 0; i < aux.length; i++) { 
 arrayvalues.push(aux[i]);
}

$(\"[data-name=\'compra\']\").text('Compra (Listar, Visualizar, Criar, Editar, Deletar)');

$('input[name=\"User[role_id]\"]').val(arrayuservalues);

$('li').filter('[data-name=\"index-compra\"]').remove();
$('li').filter('[data-name=\"view-compra\"]').remove();
$('li').filter('[data-name=\"create-compra\"]').remove();
$('li').filter('[data-name=\"update-compra\"]').remove();
$('li').filter('[data-name=\"delete-compra\"]').remove();
$('#compra-sortable li').remove();
}

else if (ui.item.data().name == 'relatorio') {
 var arrayrelatoriovalues = ['index-relatorio','view-relatorio',
 'create-relatorio','update-relatorio','delete-relatorio'];
 var arrayrelatoriotext = ['Listar','Visualizar','Criar','Editar','Deletar'];

 var aux = [];
 var auxtext = [];
 for (i = 0; i < arrayrelatoriovalues.length; i++) { 
  if (arrayvalues.indexOf(arrayrelatoriovalues[i]) < 0) {

    aux.push(arrayrelatoriovalues[i]);
    auxtext.push(arrayrelatoriotext[i]);
  }
}
for (i = 0; i < aux.length; i++) { 
 arrayvalues.push(aux[i]);
}

$(\"[data-name=\'relatorio\']\").text('Relatório (Listar, Visualizar, Criar, Editar, Deletar)');

$('input[name=\"User[role_id]\"]').val(arrayuservalues);

$('li').filter('[data-name=\"index-relatorio\"]').remove();
$('li').filter('[data-name=\"view-relatorio\"]').remove();
$('li').filter('[data-name=\"create-relatorio\"]').remove();
$('li').filter('[data-name=\"update-relatorio\"]').remove();
$('li').filter('[data-name=\"delete-relatorio\"]').remove();
$('#relatorio-sortable li').remove();
}

else if (ui.item.data().name == 'fornecedor') {
 var arrayfornecedorvalues = ['index-fornecedor','view-fornecedor',
 'create-fornecedor','update-fornecedor','delete-fornecedor'];
 var arrayfornecedortext = ['Listar','Visualizar','Criar','Editar','Deletar'];



 var aux = [];
 var auxtext = [];
 for (i = 0; i < arrayfornecedorvalues.length; i++) { 
  if (arrayvalues.indexOf(arrayfornecedorvalues[i]) < 0) {
    console.log(arrayfornecedorvalues[i]);
    aux.push(arrayfornecedorvalues[i]);
    auxtext.push(arrayfornecedortext[i]);
    console.log('arrayfornecedorvalues: '+ arrayfornecedorvalues);
  }
}
for (i = 0; i < aux.length; i++) { 
 arrayvalues.push(aux[i]);
}

$(\"[data-name=\'fornecedor\']\").text('Fornecedor (Listar, Visualizar, Criar, Editar, Deletar)');
console.log('arrayuservalues: '+ arrayuservalues);
$('input[name=\"User[role_id]\"]').val(arrayuservalues);

$('li').filter('[data-name=\"index-fornecedor\"]').remove();
$('li').filter('[data-name=\"view-fornecedor\"]').remove();
$('li').filter('[data-name=\"create-fornecedor\"]').remove();
$('li').filter('[data-name=\"update-fornecedor\"]').remove();
$('li').filter('[data-name=\"delete-fornecedor\"]').remove();
$('#fornecedor-sortable li').remove();
}

else if (ui.item.data().name == 'user') {



 /*     $(this).appendTo($('#w6 li').text('Listar Usuário'));
 $(this).appendTo($('#w6 li').text('Visualizar Usuário'));
 $(this).append('<li data-name='+'index-user'+'  data-key='+'index-user'+'  >'+'Listar Usuários'+'</li>');
 $(this).append('<li data-name='+'view-user'+'  data-key='+'view-user'+'  >'+'Visualizar Usuário'+'</li>');
 $(this).append('<li data-name='+'create-user'+'  data-key='+'create-user'+'  >'+'Criar Usuário'+'</li>');
 $(this).append('<li data-name='+'update-user'+'  data-key='+'update-user'+'  >'+'Editar Usuário'+'</li>');
 $(this).append('<li data-name='+'delete-user'+'  data-key='+'delete-user'+'  >'+'Deletar Usuário'+'</li>');
 */
 var arrayuservalues = ['index-user','view-user','create-user','update-user','delete-user'];
 var arrayusertext = ['Listar','Visualizar','Criar','Editar','Deletar'];

 console.log(arrayvalues);
 var aux = [];
 var auxtext = [];
 for (i = 0; i < arrayuservalues.length; i++) { 
  if (arrayvalues.indexOf(arrayuservalues[i]) < 0) {
    console.log(arrayuservalues[i]);
    aux.push(arrayuservalues[i]);
    auxtext.push(arrayusertext[i]);
  //  arrayuservalues.splice(arrayvalues.indexOf(arrayuservalues[i]), 1);
    console.log('arrayuservalues: '+ arrayuservalues);
  }
}
for (i = 0; i < aux.length; i++) { 
 // console.log(arrayuservalues[i]);
//  console.log(arrayusertext[i]);
 // $(this).append('<li data-name='+arrayuservalues[i]+'  data-key='+arrayuservalues[i]+'  >'+auxtext[i] + ' Usuário'+'</li>');
  arrayvalues.push(aux[i]);
}

$(\"[data-name=\'user\']\").text('Usuário (Listar, Visualizar, Criar, Editar, Deletar)');
console.log('arrayuservalues: '+ arrayuservalues);
$('input[name=\"User[role_id]\"]').val(arrayuservalues);
//$('#user-sortable').parent().remove(); 
$('li').filter('[data-name=\"index-user\"]').remove();
$('li').filter('[data-name=\"view-user\"]').remove();
$('li').filter('[data-name=\"create-user\"]').remove();
$('li').filter('[data-name=\"update-user\"]').remove();
$('li').filter('[data-name=\"delete-user\"]').remove();
$('#user-sortable li').remove();

}else{

  if (arrayvalues.indexOf(ui.item.data().name) < 0) {
  //  console.log(arrayuservalues[i]);
    arrayvalues.push(ui.item.data().name);
  }
  
//  arrayvalues.push(ui.item.data().name);

}


$('input[name=\"User[role_id]\"]').val(arrayvalues);
/*console.log(arrayvalues); */
console.log('ui.item.data().name: '+ ui.item.data().name); 
//$(this).sortable('refresh');
$(this).sortable();

var sortedIDs = $( this ).sortable( 'toArray' );
//console.log(sortedIDs); 

}",
                        'forcePlaceholderSize' => 'true',
                    ],
                ],
                'options' => ['class' => 'form-control',
                    'readonly' => true, 'placeholder' => 'Arraste para cá'],


            ]);
            ?>
        </div>
        <?php
        /* echo "<div class='col-sm-6'>";

         for ($i = 0; $i < count($permissoes); $i++) {
             echo '<div class="col-sm-6">';
             echo Html::label(Yii::t('yii', $macroauthitems[$i]))
                 . '</br>';
             echo SortableInput::widget([
                 'name' => 'kv-conn-' . $i,
                 'items' => $permissoes[$i],

                 'hideInput' => true,
                 'sortableOptions' => [
                     'connected' => true,
                     'pluginOptions' => [
                         'dropOnEmpty' => true,
                     ],
                 ],

                 'options' => ['class' => 'form-control', 'readonly' => true,
                     'id' => $macroauthitems[$i]
                 ],


             ]);
             echo '</div>';


         }
         echo '</div>';
         */ ?>
    </div>
    <?php /* uncomment if you want to add profile fields here
<?= $form->field($profile, 'full_name') ?>
        */ ?>

    <div class="form-group">
        <div class="col-sm-12">
            <?= Html::submitButton(Yii::t('user', 'Register'), ['class' => 'btn btn-primary btn-block']) ?>

            <br/><br/>
            <?= Html::a(Yii::t('user', 'Login'), ["/user/login"], ['class' => 'btn btn-primary btn-block']) ?>
        </div>
        <?php // Html::resetButton('Resetar', ['class' => 'btn btn-primary btn-block']) ?>

    </div>

    <?php ActiveForm::end(); ?>

    <?php if (Yii::$app->get("authClientCollection", false)): ?>
        <div class="col-sm-12">
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['/user/auth/login']
            ]) ?>
        </div>
    <?php endif; ?>

    <?php endif; ?>

</div>

<script>
    $(document).ready(function () {

        var arrayvalues = [];

        $("[value='2']").change(function () {
            /* console.log('[despesa]arrayvalues.: ' +arrayvalues);

             arrayvalues.forEach(function (item) {
             console.log(item);
             });
             console.log($("[value='2']").is(':checked')) ;*/
            var arraydespesavalues = ['index-despesa', 'view-despesa',
                'create-despesa', 'update-despesa', 'delete-despesa'];
            var arraydespesatext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='2']").is(':checked')) {

                $("[value='3']").prop('checked', true);
                $("[value='4']").prop('checked', true);
                $("[value='5']").prop('checked', true);
                $("[value='6']").prop('checked', true);
                $("[value='7']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraydespesavalues.length; i++) {
                    if (arrayvalues.indexOf(arraydespesavalues[i]) < 0) {

                        aux.push(arraydespesavalues[i]);
                        auxtext.push(arraydespesatext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='despesasortable' data-key='despesasortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >Despesas</li>");

            } else {

                $("[value='3']").prop('checked', false);
                $("[value='4']").prop('checked', false);
                $("[value='5']").prop('checked', false);
                $("[value='6']").prop('checked', false);
                $("[value='7']").prop('checked', false);

                for (i = 0; i < arraydespesavalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraydespesavalues[i]), 1);
                    /* console.log('indexOf(arraydespesavalues[i])'+arrayvalues.indexOf(arraydespesavalues[i]));
                     console.log('arraydespesavalues[i]'+arraydespesavalues[i]);
                     console.log('[despesa]splice->arrayvalues.: ' +arrayvalues);*/
                }

                $("[data-name='despesasortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        $("[value='8']").change(function () {
            var arraycaixavalues = ['index-caixa', 'view-caixa',
                'create-caixa', 'update-caixa', 'delete-caixa'];
            var arraycaixatext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='8']").is(':checked')) {

                $("[value='9']").prop('checked', true);
                $("[value='10']").prop('checked', true);
                $("[value='11']").prop('checked', true);
                $("[value='12']").prop('checked', true);
                $("[value='13']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraycaixavalues.length; i++) {
                    if (arrayvalues.indexOf(arraycaixavalues[i]) < 0) {

                        aux.push(arraycaixavalues[i]);
                        auxtext.push(arraycaixatext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='caixasortable' data-key='caixasortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >Caixa</li>");

            } else {

                $("[value='9']").prop('checked', false);
                $("[value='10']").prop('checked', false);
                $("[value='11']").prop('checked', false);
                $("[value='12']").prop('checked', false);
                $("[value='13']").prop('checked', false);
                for (i = 0; i < arraycaixavalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraycaixavalues[i]), 1);
                }

                $("[data-name='caixasortable']").remove();
                $("#w0").val(arrayvalues);
            }
        });

        $("[value='14']").change(function () {

            var arrayfornecedorvalues = ['index-fornecedor', 'view-fornecedor',
                'create-fornecedor', 'update-fornecedor', 'delete-fornecedor'];
            var arrayfornecedortext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='14']").is(':checked')) {

                $("[value='15']").prop('checked', true);
                $("[value='16']").prop('checked', true);
                $("[value='17']").prop('checked', true);
                $("[value='18']").prop('checked', true);
                $("[value='19']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arrayfornecedorvalues.length; i++) {
                    if (arrayvalues.indexOf(arrayfornecedorvalues[i]) < 0) {

                        aux.push(arrayfornecedorvalues[i]);
                        auxtext.push(arrayfornecedortext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='fornecedorsortable' data-key='fornecedorsortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >Fornecedores</li>");

            } else {

                $("[value='15']").prop('checked', false);
                $("[value='16']").prop('checked', false);
                $("[value='17']").prop('checked', false);
                $("[value='18']").prop('checked', false);
                $("[value='19']").prop('checked', false);

                for (i = 0; i < arrayfornecedorvalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arrayfornecedorvalues[i]), 1);

                }

                $("[data-name='fornecedorsortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });

        $("[value='20']").change(function () {

            var arrayrelatoriovalues = ['index-relatorio', 'view-relatorio',
                'create-relatorio', 'update-relatorio', 'delete-relatorio'];
            var arrayrelatoriotext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='20']").is(':checked')) {

                $("[value='21']").prop('checked', true);
                $("[value='22']").prop('checked', true);
                $("[value='23']").prop('checked', true);
                $("[value='24']").prop('checked', true);
                $("[value='25']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arrayrelatoriovalues.length; i++) {
                    if (arrayvalues.indexOf(arrayrelatoriovalues[i]) < 0) {

                        aux.push(arrayrelatoriovalues[i]);
                        auxtext.push(arrayrelatoriotext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='relatoriosortable' data-key='relatoriosortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >Relatórios</li>");

            } else {

                $("[value='21']").prop('checked', false);
                $("[value='22']").prop('checked', false);
                $("[value='23']").prop('checked', false);
                $("[value='24']").prop('checked', false);
                $("[value='25']").prop('checked', false);

                for (i = 0; i < arrayrelatoriovalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arrayrelatoriovalues[i]), 1);

                }

                $("[data-name='relatoriosortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });

        $("[value='26']").change(function () {

            var arraycompravalues = ['index-compra', 'view-compra',
                'create-compra', 'update-compra', 'delete-compra'];
            var arraycompratext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='26']").is(':checked')) {

                $("[value='27']").prop('checked', true);
                $("[value='28']").prop('checked', true);
                $("[value='29']").prop('checked', true);
                $("[value='30']").prop('checked', true);
                $("[value='31']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraycompravalues.length; i++) {
                    if (arrayvalues.indexOf(arraycompravalues[i]) < 0) {

                        aux.push(arraycompravalues[i]);
                        auxtext.push(arraycompratext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='comprasortable' data-key='comprasortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >Compras</li>");

            } else {

                $("[value='27']").prop('checked', false);
                $("[value='28']").prop('checked', false);
                $("[value='29']").prop('checked', false);
                $("[value='30']").prop('checked', false);
                $("[value='31']").prop('checked', false);

                for (i = 0; i < arraycompravalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraycompravalues[i]), 1);

                }

                $("[data-name='comprasortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        $("[value='32']").change(function () {

            var arrayuservalues = ['index-user', 'view-user',
                'create-user', 'update-user', 'delete-user'];
            var arrayusertext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='32']").is(':checked')) {

                $("[value='33']").prop('checked', true);
                $("[value='34']").prop('checked', true);
                $("[value='35']").prop('checked', true);
                $("[value='36']").prop('checked', true);
                $("[value='37']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arrayuservalues.length; i++) {
                    if (arrayvalues.indexOf(arrayuservalues[i]) < 0) {

                        aux.push(arrayuservalues[i]);
                        auxtext.push(arrayusertext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='usersortable' data-key='usersortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >Usuários</li>");

            } else {

                $("[value='33']").prop('checked', false);
                $("[value='34']").prop('checked', false);
                $("[value='35']").prop('checked', false);
                $("[value='36']").prop('checked', false);
                $("[value='37']").prop('checked', false);

                for (i = 0; i < arrayuservalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arrayuservalues[i]), 1);

                }

                $("[data-name='usersortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });
        //---------------------------------------
        $("#cb-cardapio  input[value='56']").remove();
        $("#cb-cardapio  label:contains(' Item Cardapio')").remove();

        $("#cb-cardapio  input[value='57']").remove();
        $("#cb-cardapio  label:contains(' Delete Item-Cardapio')").remove();

        $("#cb-cardapio  input[value='58']").remove();
        $("#cb-cardapio  label:contains(' Criar Item-Cardapio')").remove();

        $("#cb-cardapio  input[value='59']").remove();
        $("#cb-cardapio  label:contains(' Listar Item-Cardapio')").remove();

        $("#cb-cardapio  input[value='60']").remove();
        $("#cb-cardapio  label:contains(' Atualizar Item-Cardapio')").remove();

        $("#cb-cardapio  input[value='61']").remove();
        $("#cb-cardapio  label:contains(' Visualizar Item-Cardapio')").remove();
        //---------------------------------------
        $("[value='38']").change(function () {

            var arraycardapiovalues = ['index-cardapio', 'view-cardapio',
                'create-cardapio', 'update-cardapio', 'delete-cardapio'];
            var arraycardapiotext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='38']").is(':checked')) {

                $("[value='39']").prop('checked', true);
                $("[value='40']").prop('checked', true);
                $("[value='41']").prop('checked', true);
                $("[value='42']").prop('checked', true);
                $("[value='43']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraycardapiovalues.length; i++) {
                    if (arrayvalues.indexOf(arraycardapiovalues[i]) < 0) {

                        aux.push(arraycardapiovalues[i]);
                        auxtext.push(arraycardapiotext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='cardapiosortable' data-key='cardapiosortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >Cardápio</li>");

            } else {

                $("[value='39']").prop('checked', false);
                $("[value='40']").prop('checked', false);
                $("[value='41']").prop('checked', false);
                $("[value='42']").prop('checked', false);
                $("[value='43']").prop('checked', false);

                for (i = 0; i < arraycardapiovalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraycardapiovalues[i]), 1);

                }

                $("[data-name='cardapiosortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });

        $("[value='44']").change(function () {

            var arraydestaquevalues = ['index-destaque', 'view-destaque',
                'create-destaque', 'update-destaque', 'delete-destaque'];
            var arraydestaquetext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='44']").is(':checked')) {

                $("[value='45']").prop('checked', true);
                $("[value='46']").prop('checked', true);
                $("[value='47']").prop('checked', true);
                $("[value='48']").prop('checked', true);
                $("[value='49']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraydestaquevalues.length; i++) {
                    if (arrayvalues.indexOf(arraydestaquevalues[i]) < 0) {

                        aux.push(arraydestaquevalues[i]);
                        auxtext.push(arraydestaquetext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='destaquesortable' data-key='destaquesortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >Destaque</li>");

            } else {
                $("[value='45']").prop('checked', false);
                $("[value='46']").prop('checked', false);
                $("[value='47']").prop('checked', false);
                $("[value='48']").prop('checked', false);
                $("[value='49']").prop('checked', false);


                for (i = 0; i < arraydestaquevalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraydestaquevalues[i]), 1);

                }

                $("[data-name='destaquesortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        $("[value='50']").change(function () {

            var arrayhistoricosituacaovalues = ['index-historicosituacao', 'view-historicosituacao',
                'create-historicosituacao', 'update-historicosituacao', 'delete-historicosituacao'];
            var arrayhistoricosituacaotext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='50']").is(':checked')) {

                $("[value='51']").prop('checked', true);
                $("[value='52']").prop('checked', true);
                $("[value='53']").prop('checked', true);
                $("[value='54']").prop('checked', true);
                $("[value='55']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arrayhistoricosituacaovalues.length; i++) {
                    if (arrayvalues.indexOf(arrayhistoricosituacaovalues[i]) < 0) {

                        aux.push(arrayhistoricosituacaovalues[i]);
                        auxtext.push(arrayhistoricosituacaotext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='historicosituacaosortable' data-key='historicosituacaosortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Histórico Situação</li>");

            } else {
                $("[value='51']").prop('checked', false);
                $("[value='52']").prop('checked', false);
                $("[value='53']").prop('checked', false);
                $("[value='54']").prop('checked', false);
                $("[value='55']").prop('checked', false);


                for (i = 0; i < arrayhistoricosituacaovalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arrayhistoricosituacaovalues[i]), 1);

                }

                $("[data-name='historicosituacaosortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        $("[value='56']").change(function () {

            var arrayitemcardapiovalues = ['index-itemcardapio', 'view-itemcardapio',
                'create-itemcardapio', 'update-itemcardapio', 'delete-itemcardapio'];
            var arrayitemcardapiotext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='56']").is(':checked')) {

                $("[value='57']").prop('checked', true);
                $("[value='58']").prop('checked', true);
                $("[value='59']").prop('checked', true);
                $("[value='60']").prop('checked', true);
                $("[value='61']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arrayitemcardapiovalues.length; i++) {
                    if (arrayvalues.indexOf(arrayitemcardapiovalues[i]) < 0) {

                        aux.push(arrayitemcardapiovalues[i]);
                        auxtext.push(arrayitemcardapiotext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='itemcardapiosortable' data-key='itemcardapiosortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Item Cardápio</li>");

            } else {
                $("[value='57']").prop('checked', false);
                $("[value='58']").prop('checked', false);
                $("[value='59']").prop('checked', false);
                $("[value='60']").prop('checked', false);
                $("[value='61']").prop('checked', false);


                for (i = 0; i < arrayitemcardapiovalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arrayitemcardapiovalues[i]), 1);

                }

                $("[data-name='itemcardapiosortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        $("[value='62']").change(function () {

            var arraylojavalues = ['index-loja', 'view-loja',
                'create-loja', 'update-loja', 'delete-loja'];
            var arraylojatext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='62']").is(':checked')) {

                $("[value='63']").prop('checked', true);
                $("[value='64']").prop('checked', true);
                $("[value='65']").prop('checked', true);
                $("[value='66']").prop('checked', true);
                $("[value='67']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraylojavalues.length; i++) {
                    if (arrayvalues.indexOf(arraylojavalues[i]) < 0) {

                        aux.push(arraylojavalues[i]);
                        auxtext.push(arraylojatext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='lojasortable' data-key='lojasortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Loja</li>");

            } else {
                $("[value='63']").prop('checked', false);
                $("[value='64']").prop('checked', false);
                $("[value='65']").prop('checked', false);
                $("[value='66']").prop('checked', false);
                $("[value='67']").prop('checked', false);


                for (i = 0; i < arraylojavalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraylojavalues[i]), 1);

                }

                $("[data-name='lojasortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });

        $("[value='68']").change(function () {

            var arraymesavalues = ['index-mesa', 'view-mesa',
                'create-mesa', 'update-mesa', 'delete-mesa'];
            var arraymesatext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='68']").is(':checked')) {

                $("[value='69']").prop('checked', true);
                $("[value='70']").prop('checked', true);
                $("[value='71']").prop('checked', true);
                $("[value='72']").prop('checked', true);
                $("[value='73']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraymesavalues.length; i++) {
                    if (arrayvalues.indexOf(arraymesavalues[i]) < 0) {

                        aux.push(arraymesavalues[i]);
                        auxtext.push(arraymesatext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='mesasortable' data-key='mesasortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Mesa</li>");

            } else {
                $("[value='69']").prop('checked', false);
                $("[value='70']").prop('checked', false);
                $("[value='71']").prop('checked', false);
                $("[value='72']").prop('checked', false);
                $("[value='73']").prop('checked', false);


                for (i = 0; i < arraymesavalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraymesavalues[i]), 1);

                }

                $("[data-name='mesasortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        $("[value='74']").change(function () {

            var arraypagamentovalues = ['index-pagamento', 'view-pagamento',
                'create-pagamento', 'update-pagamento', 'delete-pagamento'];
            var arraypagamentotext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='74']").is(':checked')) {

                $("[value='75']").prop('checked', true);
                $("[value='76']").prop('checked', true);
                $("[value='77']").prop('checked', true);
                $("[value='78']").prop('checked', true);
                $("[value='79']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraypagamentovalues.length; i++) {
                    if (arrayvalues.indexOf(arraypagamentovalues[i]) < 0) {

                        aux.push(arraypagamentovalues[i]);
                        auxtext.push(arraypagamentotext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='pagamentosortable' data-key='pagamentosortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Pagamento</li>");

            } else {
                $("[value='75']").prop('checked', false);
                $("[value='76']").prop('checked', false);
                $("[value='77']").prop('checked', false);
                $("[value='78']").prop('checked', false);
                $("[value='79']").prop('checked', false);


                for (i = 0; i < arraypagamentovalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraypagamentovalues[i]), 1);

                }

                $("[data-name='pagamentosortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        //---------------------------------------
        $("#cb-pedido  input[value='111']").remove();
        $("#cb-pedido label:contains(' Item Pedido')").remove();

        $("#cb-pedido  input[value='112']").remove();
        $("#cb-pedido  label:contains(' Delete Item Pedido')").remove();

        $("#cb-pedido  input[value='113']").remove();
        $("#cb-pedido  label:contains(' Criar Item Pedido')").remove();

        $("#cb-pedido  input[value='114']").remove();
        $("#cb-pedido  label:contains(' Listar Item Pedido')").remove();

        $("#cb-pedido  input[value='115']").remove();
        $("#cb-pedido  label:contains(' Atualizar Item Pedido')").remove();

        $("#cb-pedido  input[value='116']").remove();
        $("#cb-pedido  label:contains(' Visualizar Item Pedido')").remove();
        //---------------------------------------

        $("[value='80']").change(function () {

            var arraypedidovalues = ['index-pedido', 'view-pedido',
                'create-pedido', 'update-pedido', 'delete-pedido'];
            var arraypedidotext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='80']").is(':checked')) {

                $("[value='81']").prop('checked', true);
                $("[value='82']").prop('checked', true);
                $("[value='83']").prop('checked', true);
                $("[value='84']").prop('checked', true);
                $("[value='85']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraypedidovalues.length; i++) {
                    if (arrayvalues.indexOf(arraypedidovalues[i]) < 0) {

                        aux.push(arraypedidovalues[i]);
                        auxtext.push(arraypedidotext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='pedidosortable' data-key='pedidosortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Pedido</li>");

            } else {
                $("[value='81']").prop('checked', false);
                $("[value='82']").prop('checked', false);
                $("[value='83']").prop('checked', false);
                $("[value='84']").prop('checked', false);
                $("[value='85']").prop('checked', false);


                for (i = 0; i < arraypedidovalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraypedidovalues[i]), 1);

                }

                $("[data-name='pedidosortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        $("[value='86']").change(function () {

            var arrayprodutovalues = ['index-produto', 'view-produto',
                'create-produto', 'update-produto', 'delete-produto','avaliacaoproduto','listadeprodutosporcategoria',
            'produtosvenda','definirvalorprodutovenda'];
            var arrayprodutotext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='86']").is(':checked')) {

                $("[value='87']").prop('checked', true);
                $("[value='88']").prop('checked', true);
                $("[value='89']").prop('checked', true);
                $("[value='90']").prop('checked', true);
                $("[value='91']").prop('checked', true);
                $("[value='93']").prop('checked', true);
                $("[value='94']").prop('checked', true);
                $("[value='95']").prop('checked', true);
                $("[value='96']").prop('checked', true);
                $("[value='97']").prop('checked', true);
                $("[value='98']").prop('checked', true);

                var aux = [];
                var auxtext = [];
                for (i = 0; i < arrayprodutovalues.length; i++) {
                    if (arrayvalues.indexOf(arrayprodutovalues[i]) < 0) {

                        aux.push(arrayprodutovalues[i]);
                        auxtext.push(arrayprodutotext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='produtosortable' data-key='produtosortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Produto</li>");

            } else {
                $("[value='87']").prop('checked', false);
                $("[value='88']").prop('checked', false);
                $("[value='89']").prop('checked', false);
                $("[value='90']").prop('checked', false);
                $("[value='91']").prop('checked', false);
                $("[value='93']").prop('checked', false);
                $("[value='94']").prop('checked', false);
                $("[value='95']").prop('checked', false);
                $("[value='96']").prop('checked', false);
                $("[value='97']").prop('checked', false);
                $("[value='98']").prop('checked', false);


                for (i = 0; i < arrayprodutovalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arrayprodutovalues[i]), 1);

                }

                $("[data-name='produtosortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });

        //---------------------------------------
        $("#cb-insumo  input[value='94']").remove();
        $("#cb-insumo  label:contains(' Listar Produtos de Venda por Insumo')").remove();

        $("#cb-definirvalorprodutovenda").remove();

        //---------------------------------------


        $("[value='92']").change(function () {

            var arrayinsumovalues = ['index-insumo', 'view-insumo',
                'create-insumo', 'update-insumo', 'delete-insumo'];
            var arrayinsumotext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='92']").is(':checked')) {

                $("[value='99']").prop('checked', true);
                $("[value='100']").prop('checked', true);
                $("[value='101']").prop('checked', true);
                $("[value='102']").prop('checked', true);
                $("[value='103']").prop('checked', true);
                $("[value='104']").prop('checked', true);

                var aux = [];
                var auxtext = [];
                for (i = 0; i < arrayinsumovalues.length; i++) {
                    if (arrayvalues.indexOf(arrayinsumovalues[i]) < 0) {

                        aux.push(arrayinsumovalues[i]);
                        auxtext.push(arrayinsumotext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='insumosortable' data-key='insumosortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Insumo</li>");

            } else {
                $("[value='99']").prop('checked', false);
                $("[value='100']").prop('checked', false);
                $("[value='101']").prop('checked', false);
                $("[value='102']").prop('checked', false);
                $("[value='103']").prop('checked', false);
                $("[value='104']").prop('checked', false);


                for (i = 0; i < arrayinsumovalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arrayinsumovalues[i]), 1);

                }

                $("[data-name='insumosortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        $("[value='105']").change(function () {

            var arraycategoriavalues = ['index-categoria', 'view-categoria',
                'create-categoria', 'update-categoria', 'delete-categoria'];
            var arraycategoriatext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='105']").is(':checked')) {

                $("[value='106']").prop('checked', true);
                $("[value='107']").prop('checked', true);
                $("[value='108']").prop('checked', true);
                $("[value='109']").prop('checked', true);
                $("[value='110']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraycategoriavalues.length; i++) {
                    if (arrayvalues.indexOf(arraycategoriavalues[i]) < 0) {

                        aux.push(arraycategoriavalues[i]);
                        auxtext.push(arraycategoriatext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='categoriasortable' data-key='categoriasortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Categoria</li>");

            } else {
                $("[value='106']").prop('checked', false);
                $("[value='107']").prop('checked', false);
                $("[value='108']").prop('checked', false);
                $("[value='109']").prop('checked', false);
                $("[value='110']").prop('checked', false);



                for (i = 0; i < arraycategoriavalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraycategoriavalues[i]), 1);

                }

                $("[data-name='categoriasortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        $("[value='111']").change(function () {

            var arrayitempedidovalues = ['index-itempedido', 'view-itempedido',
                'create-itempedido', 'update-itempedido', 'delete-itempedido'];
            var arrayitempedidotext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='111']").is(':checked')) {

                $("[value='112']").prop('checked', true);
                $("[value='113']").prop('checked', true);
                $("[value='114']").prop('checked', true);
                $("[value='115']").prop('checked', true);
                $("[value='116']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arrayitempedidovalues.length; i++) {
                    if (arrayvalues.indexOf(arrayitempedidovalues[i]) < 0) {

                        aux.push(arrayitempedidovalues[i]);
                        auxtext.push(arrayitempedidotext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='itempedidosortable' data-key='itempedidosortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Item Pedido</li>");

            } else {
                $("[value='112']").prop('checked', false);
                $("[value='113']").prop('checked', false);
                $("[value='114']").prop('checked', false);
                $("[value='115']").prop('checked', false);
                $("[value='116']").prop('checked', false);



                for (i = 0; i < arrayitempedidovalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arrayitempedidovalues[i]), 1);

                }

                $("[data-name='itempedidosortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });


        //---------------------------------------
        for(var i = 123; i <= 134; i++){
            $("#cb-conta  input[value='"+i+"']").remove();
        }

        $("#cb-conta label:contains(' Listar Contas a pagar')").remove();
        $("#cb-conta label:contains(' Criar Conta a pagar')").remove();
        $("#cb-conta label:contains(' Visualizar Conta a pagar')").remove();
        $("#cb-conta label:contains(' Atualizar Conta a pagar')").remove();
        $("#cb-conta label:contains(' Deletar Conta a pagar')").remove();
        $("#cb-conta label:contains(' Deletar Conta a receber')").remove();
        $("#cb-conta label:contains(' Criar Conta a receber')").remove();
        $("#cb-conta label:contains(' Visualizar Conta a receber')").remove();
        $("#cb-conta label:contains(' Atualizar Conta a receber')").remove();
        $("#cb-conta label:contains(' Listar Contas a receber')").remove();
        $("#cb-conta label:contains(' Conta a receber')").remove();
        $("#cb-conta label:contains(' Conta a pagar')").remove();
        //---------------------------------------


        $("[value='117']").change(function () {

            var arraycontavalues = ['index-conta', 'view-conta',
                'create-conta', 'update-conta', 'delete-conta'];
            var arraycontatext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='117']").is(':checked')) {

                $("[value='118']").prop('checked', true);
                $("[value='119']").prop('checked', true);
                $("[value='120']").prop('checked', true);
                $("[value='121']").prop('checked', true);
                $("[value='122']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraycontavalues.length; i++) {
                    if (arrayvalues.indexOf(arraycontavalues[i]) < 0) {

                        aux.push(arraycontavalues[i]);
                        auxtext.push(arraycontatext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='contasortable' data-key='contasortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Conta</li>");

            } else {
                $("[value='118']").prop('checked', false);
                $("[value='119']").prop('checked', false);
                $("[value='120']").prop('checked', false);
                $("[value='121']").prop('checked', false);
                $("[value='122']").prop('checked', false);

                for (i = 0; i < arraycontavalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraycontavalues[i]), 1);

                }

                $("[data-name='contasortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });

        $("[value='123']").change(function () {

            var arraycontasapagarvalues = ['index-contasapagar', 'view-contasapagar',
                'create-contasapagar', 'update-contasapagar', 'delete-contasapagar'];
            var arraycontasapagartext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='123']").is(':checked')) {

                $("[value='124']").prop('checked', true);
                $("[value='125']").prop('checked', true);
                $("[value='126']").prop('checked', true);
                $("[value='127']").prop('checked', true);
                $("[value='128']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraycontasapagarvalues.length; i++) {
                    if (arrayvalues.indexOf(arraycontasapagarvalues[i]) < 0) {

                        aux.push(arraycontasapagarvalues[i]);
                        auxtext.push(arraycontasapagartext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='contasapagarsortable' data-key='contasapagarsortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Conta a pagar</li>");

            } else {
                $("[value='124']").prop('checked', false);
                $("[value='125']").prop('checked', false);
                $("[value='126']").prop('checked', false);
                $("[value='127']").prop('checked', false);
                $("[value='128']").prop('checked', false);

                for (i = 0; i < arraycontasapagarvalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraycontasapagarvalues[i]), 1);

                }

                $("[data-name='contasapagarsortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });

        $("[value='129']").change(function () {

            var arraycontasarecebervalues = ['index-contasareceber', 'view-contasareceber',
                'create-contasareceber', 'update-contasareceber', 'delete-contasareceber'];
            var arraycontasarecebertext = ['Listar', 'Visualizar', 'Criar', 'Editar', 'Deletar'];
            if ($("[value='129']").is(':checked')) {

                $("[value='130']").prop('checked', true);
                $("[value='131']").prop('checked', true);
                $("[value='132']").prop('checked', true);
                $("[value='133']").prop('checked', true);
                $("[value='134']").prop('checked', true);


                var aux = [];
                var auxtext = [];
                for (i = 0; i < arraycontasarecebervalues.length; i++) {
                    if (arrayvalues.indexOf(arraycontasarecebervalues[i]) < 0) {

                        aux.push(arraycontasarecebervalues[i]);
                        auxtext.push(arraycontasarecebertext[i]);

                    }
                }
                for (i = 0; i < aux.length; i++) {
                    arrayvalues.push(aux[i]);
                }


                $("#w0").val(arrayvalues);
                $("#w0-sortable").append("<li data-name='contasarecebersortable' data-key='contasarecebersortable'" +
                    " role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >" +
                    "Conta a receber</li>");

            } else {
                $("[value='130']").prop('checked', false);
                $("[value='131']").prop('checked', false);
                $("[value='132']").prop('checked', false);
                $("[value='133']").prop('checked', false);
                $("[value='134']").prop('checked', false);

                for (i = 0; i < arraycontasarecebervalues.length; i++) {
                    arrayvalues.splice(arrayvalues.indexOf(arraycontasarecebervalues[i]), 1);

                }

                $("[data-name='contasarecebersortable']").remove();
                $("#w0").val(arrayvalues);
            }

        });

    });
</script>