<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Conta */
/* @var $tiposConta array */
/* @var $tiposCustoFixo array */
/* @var $modelContaapagar app\models\Contasapagar */
/* @var $modelContasareceber app\models\Contasareceber */
/* @var $modelCustofixo app\models\Custofixo */
/* @var $mensagem  mixed */
$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Conta: ',
    ]) . $model->idconta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Conta', 'url' => ['view', 'id' => $model->idconta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="conta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tiposConta' => $tiposConta,
        'modelContaapagar' => $modelContaapagar,
        'modelContasareceber' => $modelContasareceber,
        'modelCustofixo' => $modelCustofixo,
        'tiposCustoFixo' => $tiposCustoFixo,
        'mensagem' => $mensagem,
    ]) ?>

</div>
