<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelMesa app\models\Mesa */

$this->title = 'Update Mesa: ' . ' ' . $modelMesa->idMesa;
$this->params['breadcrumbs'][] = ['label' => 'Mesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelMesa->idMesa, 'url' => ['view', 'id' => $modelMesa->idMesa]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mesa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelMesa' => $modelMesa,
    ]) ?>

</div>
