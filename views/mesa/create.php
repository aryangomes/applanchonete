<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelMesa app\models\Mesa */

$this->title = 'Cadastrar Mesa';
$this->params['breadcrumbs'][] = ['label' => 'Mesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mesa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelMesa' => $modelMesa,
    ]) ?>

</div>
