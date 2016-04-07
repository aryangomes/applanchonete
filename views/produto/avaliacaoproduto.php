<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use kartik\datecontrol\DateControl;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Produto */

$this->title =  'Avaliação Produto';//$model->idProduto;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <div class="produto-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'datainicioavaliacao')->widget(DateControl::classname(), [
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

    <?= $form->field($model, 'datafimavaliacao')->widget(DateControl::classname(), [
      'type'=>DateControl::FORMAT_DATE,
      'ajaxConversion'=>false,
      'options' => [

      'pluginOptions' => [
      'autoclose' => true
      ]
      ],
      'displayFormat' => 'dd/MM/yyyy',
      'language'=>'pt',
      ]);



      ?>
      <?= $form->field($model, 'groupbyavaliacao')->dropdownList(['DAY'=>'Dia','MONTH'=>'Mês','YEAR'=>'Ano']); ?>
      <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' =>  'btn btn-primary']) ?>
      </div>
      <?php ActiveForm::end(); ?>


    </div>
  </br>

  <?php 
  if (isset($a1) && isset($a2) ) {
    HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);


    echo Highcharts::widget([
     'options' => [
     'title' => ['text' => 'Quantidade de vendas do produto'],
     'xAxis' => [
     'categories' =>$a2
     ],
     'yAxis' => [
     'title' => ['text' => 'Quantidade de produtos vendidos']
     ],
     'credits'=>false,
     'series' => [
     ['name' => 'Quantidade de produtos vendidos', 'data' =>$a1
     ],

     ]
     ]
     ]);
  }
  ?>

</div>
