<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Custofixo */

$this->title = 'Tipo de Custo Fixo: ' . $modelCustofixo->tipocustofixoIdtipocustofixo->tipocustofixo . ' | Consumo:'
.$modelCustofixo->consumo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Custo Fixos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custofixo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $modelCustofixo->idconta], ['class' => 'btn btn-primary',
            'title'=>'Clique para ir para a tela de alteração dos dados de Custo Fixo']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelCustofixo->idconta], [
            'class' => 'btn btn-danger',
            'title' => 'Clique para apagar esse Custo Fixo',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelCustofixo,
        'attributes' => [
            'idconta',
            'consumo',
            'tipocustofixoIdtipocustofixo.tipocustofixo',
        ],
    ]) ?>

</div>
