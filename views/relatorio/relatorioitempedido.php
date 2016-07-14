<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model app\models\Relatorio */
/* @var $form yii\widgets\ActiveForm */
$this->title = $model->isNewRecord ? Yii::t('app', 'Create {model}', ['model'=>'Relatório']) :
    Yii::t('app', 'View {model}', ['model'=>'Relatório']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relatorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>
<div class="relatorio-form">

   <?php $form = ActiveForm::begin(); ?>

   <?/*= $form->field($model, 'nome')->textInput(['maxlength' => true]) */?>

   <?= $form->field($model, 'datageracao' )->hiddenInput(['value'=> date('Y-m-d')])->label(false); ?>

   <?= $form->field($model, 'tipo')->dropDownList(
       $tiposRelatorio,
    ['prompt'=>'Selecione o tipo de relatório']) ?>



   <?= $form->field($model, 'inicio_intervalo')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,
    'ajaxConversion'=>false,
    'options' => [

    'pluginOptions' => [
    'autoclose' => true
    ]
    ],
    'displayFormat' => 'dd/MM/yyyy',
    'language'=>'pt',
    ]);?>

   <?= $form->field($model, 'fim_intervalo')->widget(DateControl::classname(), [
    'type'=>DateControl::FORMAT_DATE,
    'ajaxConversion'=>false,
    'options' => [

    'pluginOptions' => [
    'autoclose' => true
    ]
    ],
    'displayFormat' => 'dd/MM/yyyy',
    'language'=>'pt',
    ]); ?>
    <?= $form->field($model, 'usuario_id' )->hiddenInput(['value'=>Yii::$app->user->getId()])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idrelatorio], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
            ],
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
if(isset($model->idrelatorio)){
HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);
echo Highcharts::widget([

    'options' => [
        'chart'=>[
            'type'=>'column'],

        'title' => ['text' => 'Quantidade de produtos vendidos <b> de ' . $model->inicio_intervalo . ' até ' .$model->fim_intervalo  ],
        'xAxis' => [
            'categories' => ['Produtos de Vendas']
        ],
        'yAxis' => [
            'title' => ['text' => 'Quantidade']
        ],
        'credits'=>false,
        'series' =>$pedidos
    ]
]);
}

?>