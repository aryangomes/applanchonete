<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
/* @var $this yii\web\View */
/* @var $model app\models\Produto */

$this->title =  'Avaliação Produto';//$model->idProduto;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 

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

       ?>

   </div>
