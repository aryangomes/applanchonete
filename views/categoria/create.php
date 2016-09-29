<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelCategoria app\models\Categoria */

$this->title = Yii::t('app', 'Cadastrar Categoria');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelCategoria' => $modelCategoria,
    ]) ?>

</div>
