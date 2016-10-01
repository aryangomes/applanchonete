<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelFormapagamento app\models\Formapagamento */

$this->title =Yii::t('app', 'Create {model}', ['model' => 'Forma de Pagamento']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forma de Pagamentos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formapagamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelFormapagamento' => $modelFormapagamento,
    ]) ?>

</div>
