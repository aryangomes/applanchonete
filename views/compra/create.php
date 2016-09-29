<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelCompra app\models\Compra */
/* @var $compraProduto app\models\Compra */
/* @var $produtos array */
/* @var $mensagem mixed */
/* @var $categorias array */
/* @var $novoProduto app\models\Produto */

$this->title = Yii::t('app', 'Create {model}',['model'=>'Compra']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compra-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelCompra' => $modelCompra,
        'compraProduto' => $compraProduto,
        'produtos' => $produtos,
        'mensagem'=>$mensagem,
        'categorias'=>$categorias,
        'novoProduto'=>$novoProduto,
    ]) ?>

</div>
