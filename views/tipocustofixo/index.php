<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TipocustofixoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Create {model}', ['model' => 'Tipo de Custo Fixo']);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipocustofixo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

        <?= Html::a(Yii::t('app', 'Create {model}', ['model' => 'Tipo de Custo Fixo']), ['tipocustofixo/create'],
            ['class' => 'btn btn-success',
                'title'=>'Clique aqui para cadastrar um novo Tipo de Custo Fixo']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'idtipocustofixo',


            [
                'attribute' => 'tipocustofixo',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->tipocustofixo,['view','id' => $model->idtipocustofixo]);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>
