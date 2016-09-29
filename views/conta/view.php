<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelConta app\models\Conta */

$this->title = $modelConta->descricao;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="conta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $modelConta->idconta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelConta->idconta], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $modelConta,
        'attributes' => [
            // 'idconta',
            [
                'attribute' => 'valor',
                'value' => 'R$ ' . $modelConta->valor,
            ],
            'descricao:ntext',
            'tipoConta',
            ['label' => 'Consumo',
                'visible' => ($modelConta->tipoConta == 'custofixo') ? true : false,
                'format' => 'text',
                'value' => ($modelConta->tipoConta == 'custofixo') ?
                    $modelConta->custofixo->consumo : '',
            ],
            ['label' => 'Tipo de Custo Fixo',
                'visible' => ($modelConta->tipoConta == 'custofixo') ? true : false,
                'format' => 'text',
                'value' => ($modelConta->tipoConta == 'custofixo') ? $modelConta->custofixo
                    ->tipocustofixoIdtipocustofixo->tipocustofixo : null,
            ],


            ['attribute' => 'contasapagar.dataVencimento',
                'value' => ($modelConta->tipoConta == 'contasapagar') ? $modelConta->contasapagar->dataVencimento : '',
                'format' => 'date',
                'visible' => ($modelConta->tipoConta == 'contasapagar') ? true : false,

            ],
            ['attribute' => 'custofixo.dataVencimento',
                    'value' => ($modelConta->tipoConta == 'custofixo') ? $modelConta->contasapagar->dataVencimento : '',
                'format' => 'date',
                'visible' => ($modelConta->tipoConta == 'custofixo') ? true : false,

            ],

            ['attribute' => 'contasareceber.dataHora',
                'value' => ($modelConta->tipoConta == 'contasareceber' && isset($modelConta->contasareceber->dataHora))
                    ? date('d/m/Y H:h:i',
                        strtotime($modelConta->contasareceber->dataHora)) : '',

                'visible' => ($modelConta->tipoConta == 'contasareceber') ? true : false,

            ],

            ['attribute' => 'situacaoPagamento',
                'format' => 'text',
                'value' => $modelConta->situacaoPagamento ? 'Paga' : 'Não paga'
            ],
        ],
    ]) ?>

</div>
