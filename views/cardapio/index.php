<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CardapioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cardápios';
$this->params['breadcrumbs'][] = ['label' => 'Cardápios', 'url' => ['index']];
?>
<div class="cardapio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Criar Cardápio', ['create'], ['class' => 'btn btn-success',
            'title'=>'Clique aqui para cadastrar um novo Cardápio']) ?>
    </p>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'idCardapio',


                [
                    'attribute' => 'titulo',
                    'format' => 'raw',
                    'value' => function ($modelCardapio) {

                        return Html::a($modelCardapio->titulo, ['view', 'id' => $modelCardapio->idCardapio]);
                    }
                ],
                [

                    'attribute' => 'data',

                    'value' => function ($modelCardapio) {
                        return isset($modelCardapio->data) ?
                            Yii::$app->formatter->asDate($modelCardapio->data, 'dd/M/Y'):null;
                    },
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>

<?php
if (isset($mensagem) && !empty($mensagem)) {
    ?>
    <script type="text/javascript">alert('<?= $mensagem; ?>');</script>
    <?php
}
?>