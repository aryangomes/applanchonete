<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Destaques */

$this->title = 'Cadastrar Destaque';
$this->params['breadcrumbs'][] = ['label' => 'Destaques', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="destaques-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
