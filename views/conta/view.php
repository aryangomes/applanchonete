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
                'visible'=> ($model->tipoConta == 'custofixo')? true:false,
                'format' => 'text',
                'value' => ($model->tipoConta == 'custofixo')?
                    $model->getCustofixo($model->idconta)->consumo :'',
            ],
            ['label' => 'Tipo de Custo Fixo',
                'visible'=> ($model->tipoConta == 'custofixo')? true:false,
                'format' => 'text',
                'value' => ($model->tipoConta == 'custofixo')? $model->getCustofixo($model->idconta)
                    ->tipocustofixoIdtipocustofixo->tipocustofixo: null,
            ],
            ['label' => 'Data de Vencimento',
                'visible'=> ($model->tipoConta == 'contasapagar')? true:false,
                'format' => 'text',
                'value' => ($model->tipoConta == 'contasapagar')?
                    date('d/m/Y',strtotime($model->getContaapagar($model->idconta)->dataVencimento))
                    : null,
            ],

            ['label' => 'Data de Vencimento',
                'visible'=> ($model->tipoConta == 'contasareceber')? true:false,
                'format' => 'text',
                'value' => ($model->tipoConta == 'contasareceber') && 
                 ($model->getContaareceber($model->idconta) != null )?
                 app\models\Relatorio::formatarDataDiaMesAno(
                         ($model->getContaareceber($model->idconta)->dataHora))
                    : null,
            ],
            ['attribute'=>'situacaoPagamento',
                'format'=>'text',
                'value'=>$model->situacaoPagamento ? 'Paga' : 'Não paga'
            ],
        ],
    ]) ?>

</div>
