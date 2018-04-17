<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Informes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="informes-form">

    <?php $form = ActiveForm::begin(['action' => Url::to(['informes/create'])]); ?>

    <?= $form->field($model, 'recibe_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'motivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
