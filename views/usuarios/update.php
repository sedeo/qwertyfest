<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Modificar perfil';
$this->params['breadcrumbs'][] = ['label' => 'Tu perfil', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar perfil';
?>
<div class="usuarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
