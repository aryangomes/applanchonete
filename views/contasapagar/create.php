<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contasapagar */

$this->title = Yii::t('app', 'Create Contasapagar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contasapagars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contasapagar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
