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



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'idcaixa',
        'valorapurado',
        'valoremcaixa',
        'valorlucro',
        ],
        ]) ?>
        <p>
            <?php // Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idcaixa], ['class' => 'btn btn-primary']) ?>
            <?=  Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->idcaixa], [
                'class' => 'btn btn-danger btn-block',
                'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
                ],
                ]) ?>
            </p>
        </div>
