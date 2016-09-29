<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelCardapio app\models\Cardapio */
/* @var $modelItemCardapio app\models\Itemcardapio */
/* @var $mensagem mixed */
/* @var $produtos array */
/* @var $itensCardapio array */
$this->title = 'Alterar Cardapio: ' . ' ' . $modelCardapio->idCardapio;
$this->params['breadcrumbs'][] = ['label' => 'Cardápios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>  'Cardápio: '.$modelCardapio->titulo, 'url' => ['view', 'id' => $modelCardapio->idCardapio]];
$this->params['breadcrumbs'][] = 'Alterar';
?>
<div class="cardapio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelCardapio' => $modelCardapio,
        'modelItemCardapio'=>$modelItemCardapio,
        'mensagem' => $mensagem,
        'itensCardapio'=>$itensCardapio,
        'produtos'=>$produtos,
    ]) ?>

</div>
