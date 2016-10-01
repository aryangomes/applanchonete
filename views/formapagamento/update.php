<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelFormapagamento app\models\Formapagamento */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Forma de Pagamento',
]) .': '. $modelFormapagamento->titulo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forma de Pagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelFormapagamento->titulo, 'url' => ['view', 'id' => $modelFormapagamento->idTipoPagamento]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="formapagamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelFormapagamento' => $modelFormapagamento,
    ]) ?>

</div>
