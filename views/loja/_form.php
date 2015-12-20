<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Loja */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loja-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
