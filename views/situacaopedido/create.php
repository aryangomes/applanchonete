<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Situacaopedido */

$this->title = Yii::t('app','Create {model}', ['model' => 'Situação Pedido']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Situações Pedidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="situacaopedido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
