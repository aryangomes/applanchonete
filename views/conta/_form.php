<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;

use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $modelConta app\models\Conta */
/* @var $form yii\widgets\ActiveForm */
/* @var $tiposConta array */
/* @var $tiposCustoFixo array */
/* @var $modelContaapagar \app\models\Contasapagar */
/* @var $modelContasareceber \app\models\Contasareceber */
/* @var $modelCustofixo \app\models\Custofixo */
?>

<div class="conta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelConta, 'valor')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            'prefix' => 'R$ ',

            'allowNegative' => false,
        ]
    ]); ?>

    <?= $form->field($modelConta, 'descricao')->textarea(
        ['rows' => 6, 'placeholder' => 'Digite a descrição da conta']) ?>

    <?= $form->field($modelConta, 'tipoConta')->dropDownList(
        $tiposConta,
        ['prompt' => 'Selecione o tipo de Conta',
        'disabled'=>$modelConta->isNewRecord ? false: true]) ?>


    <?= $modelConta->isNewRecord ? '':  $form->field($modelConta, 'tipoConta')->hiddenInput(
       )->label(false) ?>

    <?= $form->field($modelConta, 'situacaoPagamento')->dropDownList(
        [1 => 'Paga', 0 => 'Não paga'], ['prompt' => 'Seleciona a situação do pagamento']) ?>

    <?= $form->field($modelContaapagar, 'dataVencimento')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATE,
        'ajaxConversion' => false,
        'options' => [

            'pluginOptions' => [
                'autoclose' => true
            ]
        ],
        'displayFormat' => 'dd/MM/yyyy',
        'language' => 'pt',
    ]); ?>

    <?php

    //Setando para o fuso horário do Brasil
    date_default_timezone_set('America/Sao_Paulo');

    echo $form->field($modelContasareceber, 'dataHora')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATETIME,
        'ajaxConversion' => false,
        'options' => [

            'pluginOptions' => [
                'autoclose' => true
            ]
        ],
        'displayFormat' => 'dd/MM/yyyy H:m:s ',
//        'language' => 'pt',
    ]); ?>


    <?= $form->field($modelCustofixo, 'consumo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelCustofixo, 'tipocustofixo_idtipocustofixo')->dropDownList($tiposCustoFixo, [
        'prompt' => 'Selecione o tipo de Custo Fixo', 'idtipocustofixo'
    ]) ?>

    <?php
    $this->registerJsFile(\Yii::getAlias("@web") . '/js/conta_form.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);


    ?>

    <div class="form-group">
        <?= Html::submitButton($modelConta->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'),
            ['class' => $modelConta->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                'title'=>$modelConta->isNewRecord ? 'Clique para cadastrar uma nova Conta':
                    'Clique para salvar os dados da Conta']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

if(isset($mensagem) && !empty($mensagem))
{
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>
