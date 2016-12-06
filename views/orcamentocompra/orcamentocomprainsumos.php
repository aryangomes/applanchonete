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

    <p class="text-danger">
    <?php 
   		if (!empty($mensagem)) {
   			echo "Os seguintes produtos não possuem preço de compra cadastradors: " . $mensagem;
   		}
    ?>
    </p>

    <div class="row">
        <div class="col-md-4">
    <?php
    echo $form->field($model, 'listaInsumos',['template'=>'<tr><td ><b>Lista de Insumos:</b><br /><br /></td><td>{input}</td></tr>'])->checkboxList($output1, ['unselect'=>NULL,
    'separator'=>'<hr>']);
    ?>
</div>
        <div class="col-md-4">
            <?php
    echo $form->field($model, 'listaInsumos',['template'=>'<tr><td ><br /><br /></td><td>{input}</td></tr>'])->checkboxList($output2, ['unselect'=>NULL,
        'separator'=>'<hr>']);
            ?>
        </div>
            <div class="col-md-4">
                <?php
    echo $form->field($model, 'listaInsumos',['template'=>'<tr><td ><br /><br /></td><td>{input}</td></tr>'])->checkboxList($output3, ['unselect'=>NULL,
        'separator'=>'<hr>']);
                ?>

               </div>
                    <?php
    ?>
    </div>
        <?php
?>

<div class="form-group">
  <?= Html::submitButton('Gerar Orçamento', ['class' => 'btn btn-primary',
      'title'=>'Clique aqui para gerar um orçamento de uma Compra']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>