<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Itemcardapio */

$this->title = $model->idCardapio;
$this->params['breadcrumbs'][] = ['label' => 'Itemcardapios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itemcardapio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idCardapio' => $model->idCardapio, 'idProduto' => $model->idProduto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idCardapio' => $model->idCardapio, 'idProduto' => $model->idProduto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idCardapio',
            'idProduto',
            'status',
            'ordem',
        ],
    ]) ?>

</div>
