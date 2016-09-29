<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelCustofixo app\models\Custofixo */

$this->title =  Yii::t('app', 'Create {model}', ['model' => 'Custo Fixo']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Custofixos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custofixo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelCustofixo' => $modelCustofixo,
        'tiposCustoFixo'=>$tiposCustoFixo
    ]) ?>

</div>
