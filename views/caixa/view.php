<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Caixa */

//$this->title = $model->idcaixa;
$this->title = 'Caixa';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Caixa'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caixa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idcaixa], ['class' => 'btn btn-primary']) ?>
        <?php /* Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idcaixa], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
            'method' => 'post',
            ],
            ]) */?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
           // 'idcaixa',
            'valorapurado',
            'valoremcaixa',
            'valorlucro',
            ],
            ]) ?>

        </div>
