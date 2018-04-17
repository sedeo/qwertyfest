<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InformesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Informes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            [
                'attribute' => 'recibe.nombre',
                'format' => 'text',
                'label' => 'Enviado a',
            ],
            [
                'attribute' => 'envia.nombre',
                'format' => 'text',
                'label' => 'Enviado por',
            ],
            'motivo',
            'descripcion',
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
