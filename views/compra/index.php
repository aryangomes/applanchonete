<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Fornecedor;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CompraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Compras');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {model}',
        ['model'=>Yii::t('app','Compra')]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],


        [
        'attribute'=>'datacompra',
        'format'=>'text',
       // 'label'=>'Fornecedor',
        'value'=> function($model){
            $formatter = \Yii::$app->formatter;
            return $formatter->asDate($model->datacompra, 'dd/MM/yyyy');
        }

        ],
        'totalcompra',
      //  'idcompra',
       // 'fornecedor_idFornecedor',
        [
       // 'attribute'=>'fornecedor_idFornecedor',
        'format'=>'text',
        'label'=>'Fornecedor',
        'value'=> function($model){
                //'format'=>'html';
                //return '<img src="" /> ';
            $fornecedor = new Fornecedor();
            $fornecedor = $fornecedor::getNomeFornecedor($model->fornecedor_idFornecedor);

            return $fornecedor->nome;
        }

        ],
        ['class' => 'yii\grid\ActionColumn'],
        ],
        ]); ?>

    </div>