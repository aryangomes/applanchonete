<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Conta */

$this->title = $model->descricao;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="conta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->idconta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idconta], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'idconta',
            'valor',
            'descricao:ntext',
            'tipoConta',
            ['label' => 'Consumo',
                'visible' => ($model->tipoConta == 'custofixo') ? true : false,
                'format' => 'text',
                'value' => ($model->tipoConta == 'custofixo') ?
                    $model->getCustofixo($model->idconta)->consumo : '',
            ],
            ['label' => 'Tipo de Custo Fixo',
                'visible' => ($model->tipoConta == 'custofixo') ? true : false,
                'format' => 'text',
                'value' => ($model->tipoConta == 'custofixo') ? $model->getCustofixo($model->idconta)
                    ->tipocustofixoIdtipocustofixo->tipocustofixo : null,
            ],


            ['attribute' => 'contasapagar.dataVencimento',
                'value' => ($model->tipoConta == 'contasapagar') ? $model->contasapagar->dataVencimento : '',
                'format' => 'date',
                'visible' => ($model->tipoConta == 'contasapagar') ? true : false,

            ],


            ['attribute' => 'contasareceber.dataHora',
                'value' => ($model->tipoConta == 'contasareceber' && isset($model->contasareceber->dataHora))
                    ? date('d/m/Y H:h:i',
                        strtotime($model->contasareceber->dataHora)) : '',

                'visible' => ($model->tipoConta == 'contasareceber') ? true : false,

            ],

            ['attribute' => 'situacaoPagamento',
                'format' => 'text',
                'value' => $model->situacaoPagamento ? 'Paga' : 'Não paga'
            ],
        ],
    ]) ?>

</div>
