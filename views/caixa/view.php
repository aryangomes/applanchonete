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
            <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->idcaixa], ['class' => 'btn btn-primary btn-block']) ?>
            <?=   Html::a(Yii::t('yii', 'Fechar Caixar'), ['fechar', 'id' => $model->idcaixa], [
                'class' => 'btn btn-danger btn-block',
                'data' => [
                'confirm' => Yii::t('yii', 'Tem certeza que quer fechar o caixa?'),
                'method' => 'post',
                ],
                ]) ?>
            </p>
        </div>
