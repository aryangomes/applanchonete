<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use kartik\widgets\DatePicker; 
use kartik\datecontrol\DateControl; 

/* @var $this yii\web\View */
/* @var $modelCaixa app\models\Caixa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="caixa-form">

<?php $form = ActiveForm::begin(); ?>

    

    <?=
    $form->field($modelCaixa, 'valorapurado')->widget(MaskMoney::classname(), [
        'options' => [
            'value' => $modelCaixa->valorapurado],
        'pluginOptions' => [
            'prefix' => 'R$ ',
            'allowNegative' => false,
        ]
    ]);
    ?>

    <?=
    $form->field($modelCaixa, 'valoremcaixa')->widget(MaskMoney::classname(), [
        'options' => [
            'value' => $modelCaixa->valoremcaixa],
        'pluginOptions' => [
            'prefix' => 'R$ ',
            'allowNegative' => false,
        ]
    ]);
    ?>

    <?=
    $form->field($modelCaixa, 'valorlucro')->widget(MaskMoney::classname(), [
        'options' => [
            'value' => $modelCaixa->valorlucro],
        'pluginOptions' => [
            'prefix' => 'R$ ',
            'allowNegative' => false,
        ]
    ]);
    ?>
    <?= $form->field($modelCaixa, 'user_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>

<?php
$modelCaixa->dataabertura = date('d/m/Y');
?> 




    <div class="form-group">
<?= Html::submitButton($modelCaixa->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'),
    ['class' => $modelCaixa->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        'title'=>'Clique para alterar os valores do Caixa']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
