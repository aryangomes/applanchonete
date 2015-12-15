<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Fornecedor */

$this->title = $model->idFornecedor;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fornecedors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fornecedor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idFornecedor], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idFornecedor], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cnpj',
            'nome',
            'endereco',
            'idFornecedor',
        ],
    ]) ?>

</div>
