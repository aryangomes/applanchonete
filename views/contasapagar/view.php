<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contasapagar */

$this->title = 'Conta: ' . $modelContasapagar->idconta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contas a pagar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contasapagar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $modelContasapagar->idconta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelContasapagar->idconta], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelContasapagar,
        'attributes' => [
            ['attribute' => 'conta',
                'format' => 'text',
                'label' => 'Conta',
                'value' => $modelContasapagar->conta->descricao

            ],

            ['attribute' => 'dataVencimento',
                'format' => 'text',
                'value' =>
                    isset($modelContasapagar->dataVencimento) ?
                        \Yii::$app->formatter->asDate($modelContasapagar->dataVencimento, 'dd/MM/yyyy') : null
            ],
        ],
    ]) ?>

</div>
