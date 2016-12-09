<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RelatorioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $modelRelatorio \app\models\Relatorio */


$this->title = Yii::t('app', 'Relatorios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relatorio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}',
            ['model' => Yii::t('app', 'Relatório')]), ['create'], ['class' => 'btn btn-success', 'title' => 'Criar um novo relatório']) ?>
    </p>
    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],


                [
                    'format' => 'raw',
                    'label' => 'Ação',
                    'value' => function ($modelRelatorio) {
                        return Html::a('Visualizar relatório', ['relatorio' . strtolower($modelRelatorio->tipo), 'id' => $modelRelatorio->idrelatorio]);
                    },
                ],
                [

                    'attribute' => 'datageracao',

                    'value' => function ($modelRelatorio) {
                        return isset($modelRelatorio->datageracao) ?
                            Yii::$app->formatter->asDate($modelRelatorio->datageracao, 'dd/M/Y à\s HH:m'):null;
                    },
                ],

                [
                    'attribute' =>'tipo',
                    'filter'=>[

                        'Contasareceber' => 'Contas a Receber',
                        'Pagamento' => 'Pagamento',
                        'Pedido' => 'Pedidos',
                        'Itempedido' => 'Item(ns) Pedido',
                        'Lucro' => 'Lucro',
                    ],

                    'value' => function ($modelRelatorio) {

                        return $modelRelatorio->getTipoRelatorio();
                    }
                ],

                [

                    'attribute' => 'inicio_intervalo',

                    'value' => function ($modelRelatorio) {
                        return isset($modelRelatorio->inicio_intervalo) ?
                            Yii::$app->formatter->asDate($modelRelatorio->inicio_intervalo, 'dd/M/Y'):null;
                    },
                ],

                [

                    'attribute' => 'fim_intervalo',

                    'value' => function ($modelRelatorio) {
                        return isset($modelRelatorio->fim_intervalo) ?
                            Yii::$app->formatter->asDate($modelRelatorio->fim_intervalo, 'dd/M/Y'):null;
                    },
                ],
                // 'usuario_id',

                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}', ],
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
