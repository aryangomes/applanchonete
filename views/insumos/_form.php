<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Insumos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insumos-form">

	<?php $form = ActiveForm::begin(); ?>



	<?= $form->field($model, 'idprodutoVenda')->textInput() ?>

	<?= $form->field($model, 'idprodutoInsumo')->textInput() ?>

	<?= $form->field($model, 'quantidade')->textInput([ 'type' => 'number', 'value'=>0]) ?>


	<?= $form->field($model, 'unidade')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
