<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput
/* @var $this yii\web\View */
/* @var $model app\models\Fornecedor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fornecedor-form">

	<?php $form = ActiveForm::begin(); ?>

	<?php // $form->field($model, 'cnpj')->textInput();

	echo MaskedInput::widget([
		'model'=>$model,
		'attribute' => 'cnpj',
		'mask'=>'99.999.999/9999-99',
		]);

		?>

		<?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>
