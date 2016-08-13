<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\Relatorio */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Relatório de Pedidos Feitos';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relatorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= '<p>'.Html::encode($this->title).'</p>' ?></h1>
<div class="relatorio-form">

   <?=  '<h4><p>Quantidade de Pedidos feitos de <b>' .
                $model->formatarDataDiaMesAno($model->inicio_intervalo) . ' até ' .
                $model->formatarDataDiaMesAno($model->fim_intervalo) .'</p></h4>'?>
    
    <?php

    if (isset($model->idrelatorio)) {
          
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>

                    <th>Data</th>
                    <th>Quantidade de pedidos</th>

                </tr>
            </thead>
            <tbody>
                <?php
                        for ($i = 0; $i < count($dadosPedido[0]) ; $i++){
                      
                        ?>

                        <tr>
                            <td><?= $dadosPedido[0][$i]['name']?></td>
 <td><?=$dadosPedido[0][$i]['data'][0] ?></td>
                        </tr>
                    <?php 
                }
                ?>
                        
            </tbody>
        </table>
        <?php
      
    }
    ?>
</div>