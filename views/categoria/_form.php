<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelCategoria app\models\Categoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($modelCategoria, 'nome')->textInput(['maxlength' => true,
	'placeholder'=>'Digite o nome da categoria']) ?>

	<div class="form-group">
		<?= Html::submitButton($modelCategoria->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'),
			['class' => $modelCategoria->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
				'title'=>$modelCategoria->isNewRecord ? 'Clique para cadastrar uma nova Categoria':
					'Clique para salvar os dados da Categoria']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
