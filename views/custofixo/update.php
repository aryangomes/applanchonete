<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelCustofixo app\models\Custofixo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Custo Fixo',
    ]) . ': Tipo de Custo Fixo ' . $modelCustofixo->tipocustofixoIdtipocustofixo->tipocustofixo . ' | Consumo:'
    . $modelCustofixo->consumo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Custos Fixos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Custo Fixo ' . $modelCustofixo->tipocustofixoIdtipocustofixo->tipocustofixo .
    ' | Consumo:'
    . $modelCustofixo->consumo,
    'url' => ['view', 'id' => $modelCustofixo->idconta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="custofixo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelCustofixo' => $modelCustofixo,
        'tiposCustoFixo' => $tiposCustoFixo
    ]) ?>

</div>
