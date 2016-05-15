<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tipopagamento */

$this->title = Yii::t('app', 'Create Tipopagamento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipopagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipopagamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
