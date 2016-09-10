<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Itemcardapio */

$this->title = 'Update Itemcardapio: ' . ' ' . $model->idCardapio;
$this->params['breadcrumbs'][] = ['label' => 'Itemcardapios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idCardapio, 'url' => ['view', 'idCardapio' => $model->idCardapio, 'idProduto' => $model->idProduto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="itemcardapio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>
