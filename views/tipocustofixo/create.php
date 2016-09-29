<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelTipocustofixo app\models\Tipocustofixo */


$this->title = Yii::t('app', 'Create {model}',
    ['model'=>Yii::t('app','Tipocustofixo')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo de Custo Fixos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipocustofixo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelTipocustofixo' => $modelTipocustofixo,
    ]) ?>

</div>
