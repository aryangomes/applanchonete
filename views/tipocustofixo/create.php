<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tipocustofixo */

$this->title = Yii::t('app', 'Create Tipocustofixo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipocustofixos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipocustofixo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
