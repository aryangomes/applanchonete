<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelMesa app\models\Mesa */

$this->title = 'Mesa: ' . $modelMesa->idMesa;
$this->params['breadcrumbs'][] = ['label' => 'Mesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mesa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Alterar', ['update', 'id' => $modelMesa->idMesa], ['class' => 'btn btn-primary',
            'title'=>'Clique para ir para a tela de alteração dos dados da Mesa']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $modelMesa->idMesa], [
            'class' => 'btn btn-danger',
            'title' => 'Clique para apagar essa Mesa',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelMesa,
        'attributes' => [
            'idMesa',
//            'numeroDaMesa',

            [
                'attribute' => 'alerta',
                'value' => $modelMesa->alerta ? 'Ligado' : 'Desligado',
            ],

            'qrcode',
//            'chave',
//            'cont',
        ],
    ]) ?>

</div>
