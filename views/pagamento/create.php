<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelPagamento app\models\Pagamento */

$this->title = Yii::t('app', 'Create Pagamento');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pagamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelPagamento' => $modelPagamento,
    ]) ?>

</div>
