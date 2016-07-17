<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Formapagamento */

$this->title = Yii::t('app', 'Create Formapagamento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Formapagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formapagamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
