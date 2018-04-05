<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

if($model->id === Yii::$app->user->id) {
    $this->title = "Tu perfil";
} else {
    $this->title = "Perfil de " . $model->nombre;
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'direccion',
            'fec_nac:date',
            'telefono',
            'created_at:date',
        ],
    ]) ?>


    <?php if($model->id === Yii::$app->user->id): ?>
        <p>
            <?= Html::a('Modificar perfil', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Borrar cuenta', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '¿Estás seguro de que quieres borrar tu cuenta? Perderas toda información, como amigos, grupos, etc...',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif ?>



</div>
