<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contasareceber */

$this->title = Yii::t('app', 'Create Contasareceber');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contasarecebers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contasareceber-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
