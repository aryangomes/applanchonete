<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Historicosituacao */

$this->title = 'Create Historicosituacao';
$this->params['breadcrumbs'][] = ['label' => 'Historicosituacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historicosituacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>