<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelRelatorio app\models\Relatorio */

$this->title = 'Relatório '.$modelRelatorio->idrelatorio;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Relatorios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relatorio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $modelRelatorio->idrelatorio], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelRelatorio->idrelatorio], [
            'class' => 'btn btn-danger',
            'data' => [
            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'method' => 'post',
            ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $modelRelatorio,
            'attributes' => [
            'idrelatorio',
            'nome',
            'datageracao',
            'tipo',
            'inicio_intervalo',
            'fim_intervalo',
            'usuario_id',
            ],
            ]) ?>

        </div>

