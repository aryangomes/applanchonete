<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipocustofixo */

$this->title = 'Tipo de Custo Fixo: '.$modelTipocustofixo->tipocustofixo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo de Custo Fixos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipocustofixo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $modelTipocustofixo->idtipocustofixo], ['class' => 'btn btn-primary',
            'title'=>'Clique para ir para a tela de alteração dos dados de Tipo de Custo Fixo']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelTipocustofixo->idtipocustofixo], [
            'class' => 'btn btn-danger',
            'title' => 'Clique para apagar esse Tipo de Custo Fixo',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelTipocustofixo,
        'attributes' => [

            'tipocustofixo',
        ],
    ]) ?>

</div>
