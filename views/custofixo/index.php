<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustofixoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Custos fixos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Custos Fixos'), 'url' => ['index']];
?>
<div class="custofixo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>


    </p>
    <?php Pjax::begin(); ?>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                [
                    'attribute' => 'consumo',
                    'format' => 'raw',
                    'value' => function ($modelCustofixo) {

                        return Html::a('Consumo: '.$modelCustofixo->consumo, ['conta/view', 'id' => $modelCustofixo->idconta]);
                    }
                ],
                [
                    'attribute' => 'tipocustofixoIdtipocustofixo',
                    'label' => 'Tipo de Custo Fixo',
                    'value' => 'tipocustofixoIdtipocustofixo.tipocustofixo'

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