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

<div class="form-group">
	<h2>Orçamento para compra de produtos</h2>
  	<p>Esse orçamento usa como base quanto cada produto custava na última compra.</p>            
  <table class="table">
    <thead>
      <tr>
        <th>Produto</th>
        <th>Preço</th>
      </tr>
    </thead>
    
    <?php 
    	$valorTotalFloat = floatval ($valorTotal);
    	foreach ($listaCompleta as $key => $lista) {
    ?>
    
    <tbody>
      <tr>
        <td><?= $lista[0]['nome']?></td>
        <td><?= "R$ " . $lista[0]['valorCompra']?></td>
      </tr>
    </tbody>
    <?php } ?>
    <tbody>
      <tr class="bg-info">
        <td><b>Previsão de Gastos: </td>
        <td><b><?= "R$ " . $valorTotal?></b></td>
      </tr>
    </tbody>
  </table>
</div>

<?php ActiveForm::end(); ?>

</div>