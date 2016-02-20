<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Destaques */

$this->title = $model->idDestaques;
$this->params['breadcrumbs'][] = ['label' => 'Destaques', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destaques-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idDestaques], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idDestaques], [
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
            'idDestaques',
            'titulo',
            'dataEntrada',
            'dataSaida',
            'link',
            'status',
        ],
    ]) ?>

</div>
