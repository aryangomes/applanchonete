<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelConta app\models\Conta */
/* @var $tiposConta array */
/* @var $tiposCustoFixo array */
/* @var $modelContaapagar app\models\Contasapagar */
/* @var $modelContasareceber app\models\Contasareceber */
/* @var $modelCustofixo app\models\Custofixo */
/* @var $mensagem  mixed */

$this->title = Yii::t('app', 'Create {model}', ['model' => 'Conta']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelConta' => $modelConta,
        'tiposConta' => $tiposConta,
        'modelContaapagar' => $modelContaapagar,
        'modelContasareceber' => $modelContasareceber,
        'modelCustofixo' => $modelCustofixo,
        'tiposCustoFixo'=>$tiposCustoFixo,
        'mensagem'=>$mensagem,
    ]) ?>

</div>
