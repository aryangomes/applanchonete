<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContasareceberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contas a receber');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contas a receber'), 'url' => ['index']];
?>
<div class="contasareceber-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a(Yii::t('app', 'Create {model}',['model'=>'Conta a receber']), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                [
                    'attribute' => 'conta',
                    'format' => 'raw',
                    'value' => function ($modelContasareceber) {

                        return Html::a(isset($modelContasareceber->conta->descricao)?
                            $modelContasareceber->conta->descricao:
                            "Conta sem descrição", ['conta/view', 'id' => $modelContasareceber->idconta]);
                    }
                ],


                ['attribute' => 'dataHora',
                    'format' => 'text',
                    'value' => function ($modelContasareceber) {
                        return isset($modelContasareceber->dataHora) ?
                            date("d/m/Y H:i", strtotime($modelContasareceber->dataHora)) : null;
                    }
                ],

                ['class' => 'yii\grid\ActionColumn',

                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-glyphicon glyphicon-eye-open"></span>',
                                \yii\helpers\Url::to(['conta/view', 'id' => $model->idconta])
                            );
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-glyphicon glyphicon-pencil"></span>',
                                \yii\helpers\Url::to(['conta/update', 'id' => $model->idconta])
                            );
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>


<?php
if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>