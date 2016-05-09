<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Compraproduto */

$this->title = Yii::t('app', 'Create Compraproduto');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Compraprodutos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compraproduto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
