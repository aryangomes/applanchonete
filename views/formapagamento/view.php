<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelFormapagamento app\models\Formapagamento */

$this->title = 'Forma de Pagamento: '. $modelFormapagamento->titulo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forma de Pagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formapagamento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $modelFormapagamento->idTipoPagamento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelFormapagamento->idTipoPagamento], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelFormapagamento,
        'attributes' => [

            'titulo',
            'descricao:ntext',
        ],
    ]) ?>

</div>
