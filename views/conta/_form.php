<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;

use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Conta */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="conta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'valor')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            'prefix' => 'R$ ',

            'allowNegative' => false,
        ]
    ]); ?>

    <?= $form->field($model, 'descricao')->textarea(
        ['rows' => 6, 'placeholder' => 'Digite a descrição da conta']) ?>

    <?= $form->field($model, 'tipoConta')->dropDownList(
        $tiposConta,
        ['prompt' => 'Selecione o tipo de Conta']) ?>

    <?= $form->field($model, 'situacaoPagamento')->dropDownList(
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

    <?= $form->field($modelContasareceber, 'dataHora')->widget(DateControl::classname(), [
        'type' => DateControl::FORMAT_DATETIME,
        'ajaxConversion' => false,
        'options' => [

            'pluginOptions' => [
                'autoclose' => true
            ]
        ],
        'displayFormat' => 'dd/MM/yyyy H:m ',
        'language' => 'pt',
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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

if(isset($mensagem) && !empty($mensagem))
{
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?
}
?>
