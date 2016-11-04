<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelCaixa app\models\Caixa */

//$this->title = $modelCaixa->idcaixa;
$this->title = 'Caixa';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Caixa'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caixa-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $modelCaixa,
        'attributes' => [
            // 'idcaixa',

            [
                'attribute' => 'valorapurado',
                'value' => 'R$ ' . $modelCaixa->valorapurado,
            ],
            [
                'attribute' => 'valoremcaixa',
                'value' => 'R$ ' . $modelCaixa->valoremcaixa,
            ],
            [
                'attribute' => 'valorlucro',
                'value' => 'R$ ' . $modelCaixa->valorlucro,
            ],

        ],
    ]) ?>
    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $modelCaixa->idcaixa],
            ['class' => 'btn btn-primary btn-block',
            'title'=>'Clique para alterar os valores do Caixa']) ?>
        <?= Html::a(Yii::t('yii', 'Fechar Caixar'), ['fechar', 'id' => $modelCaixa->idcaixa], [
            'class' => 'btn btn-danger btn-block',
            'data' => [
                'confirm' => Yii::t('yii', 'Tem certeza que quer fechar o caixa?'),
                'method' => 'post',
            ],
            'title'=>'Clique aqui fechar o Caixa'
        ]) ?>
    </p>
</div>
