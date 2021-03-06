<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelProduto app\models\Produto */
/* @var $categorias array */
/* @var $insumos array */
/* @var $insumo \app\models\Insumo */
/* @var $mensagem mixed */


$this->title = Yii::t('app', 'Create {model}', ['model' => 'Produto']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Produtos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<script src="/applanchonete/web/admin/js/jquery.js"></script>
<div class="produto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelProduto' => $modelProduto,
        'categorias' => $categorias,
        'insumos' => $insumos,
        'modelInsumo' => $modelInsumo,
        'mensagem' => $mensagem,
    ]) ?>

</div>
