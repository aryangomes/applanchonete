<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CompraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Compras');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orcamentocompra-index">

<?php $form = ActiveForm::begin(); ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
    

    $options = \yii\helpers\ArrayHelper::map($listaInsumosCadastrados, 'idProduto', 'nome');
    echo $form->field($model, 'listaInsumos')->checkboxList($options, ['unselect'=>NULL]);

?>

<div class="form-group">
  <?= Html::submitButton('Gerar Orçamento', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>