<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Itemcardapio */

$this->title = 'Create Itemcardapio';
$this->params['breadcrumbs'][] = ['label' => 'Itemcardapios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itemcardapio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
