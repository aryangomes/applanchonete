<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelMesa app\models\Mesa */

$this->title = 'Alterar Mesa: ' . ' ' . $modelMesa->idMesa;
$this->params['breadcrumbs'][] = ['label' => 'Mesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelMesa->numeroDaMesa, 'url' => ['view', 'id' => $modelMesa->idMesa]];
$this->params['breadcrumbs'][] =$this->title;
?>
<div class="mesa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelMesa' => $modelMesa,
    ]) ?>

</div>
