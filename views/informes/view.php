<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Informes */

$this->title = 'Informe#' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Informes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Enviado a',
                'value' => Html::a($model->recibe->nombre, ['usuarios/view', 'id' => $model->recibe_id]),
                'format' => 'html'
            ],
            [
                'label' => 'Enviado por',
                'value' => Html::a($model->envia->nombre, ['usuarios/view', 'id' => $model->envia_id]),
                'format' => 'html'
            ],
            'motivo',
            'descripcion',
            'created_at:datetime',
        ],
    ]) ?>

    <p>
        <?= Html::a('Borrar informe', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Borrar el ' . $this->title . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
