<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelTipocustofixo app\models\Tipocustofixo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tipocustofixo',
]) . $modelTipocustofixo->idtipocustofixo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo de Custo Fixos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelTipocustofixo->tipocustofixo, 'url' => ['view', 'id' => $modelTipocustofixo->idtipocustofixo]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tipocustofixo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelTipocustofixo' => $modelTipocustofixo,
    ]) ?>

</div>
