<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use kartik\datecontrol\DateControl;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $modelProduto app\models\Produto */
/* @var $datainicioavaliacao mixed */
/* @var $datafimavaliacao mixed */


$this->title =  'Avaliação Produto: ' . $modelProduto->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="produto-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <div class="produto-form">
    <?php $form = ActiveForm::begin(); ?>
      <div class="form-group datainicioavaliacao">
          <?= Html::label("De") ?>
    <?=  DateControl::widget([
        'name'=>'datainicioavaliacao',
              'value'=>(isset($datainicio)) ? $datainicio : date('Y-m-d'),
        'type'=>DateControl::FORMAT_DATE,
    'ajaxConversion'=>false,
		'options' => [

		'pluginOptions' => [
		'autoclose' => true
		]
		],
		'displayFormat' => 'dd/MM/yyyy',
		'language'=>'pt',

])?>
</div>
      <div class="form-group datafimavaliacao">
          <?= Html::label("Até") ?>
    <?= DateControl::widget([
        'name'=>'datafimavaliacao',
       'value'=>(isset($datafim)) ? $datafim : date('Y-m-d'),
        'type'=>DateControl::FORMAT_DATE,
    'ajaxConversion'=>false,
		'options' => [

		'pluginOptions' => [
		'autoclose' => true
		]
		],
		'displayFormat' => 'dd/MM/yyyy',
		'language'=>'pt',
    ])
      ?>
          </div>
      <?= $form->field($modelProduto, 'groupbyavaliacao')->dropDownList(['DAY'=>'Dia','MONTH'=>'Mês','YEAR'=>'Ano']); ?>
      <div class="form-group">
        <?= Html::submitButton('Gerar gráfico <i class="fa fa-line-chart"></i>', ['class' =>  'btn btn-primary btn-block']) ?>
      </div>
      <?php ActiveForm::end(); ?>


    </div>
  </br>

  <?php 
  if (isset($qtdvendas) && isset($datasvendas) ) {
    if (count($qtdvendas) > 0) {
      HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);
      echo Highcharts::widget([

       'options' => [
       'chart'=>[
       'type'=>'area'],

       'title' => ['text' => 'Total de vendas do produto: <b>' . $modelProduto->nome
       . '</b> - de ' . $datainicioavaliacao . ' até ' . $datafimavaliacao ],
       'xAxis' => [
       'categories' =>$datasvendas
       ],
       'yAxis' => [
       'title' => ['text' => 'Quantidade de produtos vendidos']
       ],
       'credits'=>false,
       'series' => [
       ['name' => 'Quantidade de produtos vendidos', 'data' =>$qtdvendas
       ],

       ]
       ]
       ]);
    }else{
      if (count($qtdvendas) <= 0) {
        ?>
        <div class="alert alert-danger">
          Não há vendas cadastradas para o produto <b><?= $modelProduto->nome ?></b> nesse período
        </div>
        <?php
      }
    }
  }
  ?>

</div>
