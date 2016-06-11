<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipocustofixo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tipocustofixo',
]) . $model->idtipocustofixo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipocustofixos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idtipocustofixo, 'url' => ['view', 'id' => $model->idtipocustofixo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tipocustofixo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
