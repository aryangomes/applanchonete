<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Mesa */

$this->title = 'Mesa: ' . $model->idMesa;
$this->params['breadcrumbs'][] = ['label' => 'Mesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mesa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Alterar', ['update', 'id' => $model->idMesa], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->idMesa], [
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
            'idMesa',
            'descricao',
           [
               'attribute'=> 'disponivel',
               'value'=>$model->disponivel?'Disponível':'Não Disponível',
           ],
            [
                'attribute'=>   'alerta',
                'value'=>$model->alerta?'Ligado':'Desligado',
            ],

            'qrcode',
            'chave',
            'cont',
        ],
    ]) ?>

</div>
