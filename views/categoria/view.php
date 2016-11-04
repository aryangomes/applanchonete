<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $modelCategoria app\models\Categoria */

$this->title = $modelCategoria->nome;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categorias'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $modelCategoria->idCategoria], ['class' => 'btn btn-primary',
            'title'=>'Clique para ir para a tela de alteração dos dados da Categoria']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $modelCategoria->idCategoria], [
            'class' => 'btn btn-danger',
            'title' => 'Clique para apagar essa Categoria',
            'data' => [
            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'method' => 'post',
            ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $modelCategoria,
            'attributes' => [
           // 'idCategoria',
            'nome',
            ],
            ]) ?>

        </div>
