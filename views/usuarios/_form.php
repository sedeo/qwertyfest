<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'conf_pass')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fec_nac')->textInput() ?>

    <?= $form->field($model, 'telefono')->textInput() ?>

    <?php if($model->scenario == 'create'): ?>
        <div class="form-group">
            <?= Html::submitButton('Registrar', ['class' => 'btn btn-success']) ?>
        </div>
    <?php elseif ($model->scenario == 'update'): ?>
        <div class="form-group">
            <?= Html::submitButton('Guardar cambios', ['class' => 'btn btn-success']) ?>
        </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
