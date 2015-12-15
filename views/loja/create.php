<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Loja */

$this->title = Yii::t('app', 'Create Loja');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lojas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loja-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
