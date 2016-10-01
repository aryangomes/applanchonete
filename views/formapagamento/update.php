<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelFormapagamento app\models\Formapagamento */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Formapagamento',
]) . $modelFormapagamento->idTipoPagamento;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Formapagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelFormapagamento->idTipoPagamento, 'url' => ['view', 'id' => $modelFormapagamento->idTipoPagamento]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="formapagamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelFormapagamento' => $modelFormapagamento,
    ]) ?>

</div>
