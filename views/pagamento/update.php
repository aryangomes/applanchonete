<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pagamento */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Pagamento',
]) . $model->idConta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idConta, 'url' => ['view', 'idConta' => $model->idConta, 'idPedido' => $model->idPedido]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pagamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
