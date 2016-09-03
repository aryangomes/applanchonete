<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Conta */

$this->title = Yii::t('app', 'Create {model}', ['model' => 'Conta']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tiposConta' => $tiposConta,
        'modelContaapagar' => $modelContaapagar,
        'modelContasareceber' => $modelContasareceber,
        'modelCustofixo' => $modelCustofixo,
        'tiposCustoFixo'=>$tiposCustoFixo,
        'mensagem'=>$mensagem,
    ]) ?>

</div>
