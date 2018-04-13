<?php

use yii\grid\ActionColumn;

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salas-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear sala de chat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [
            'propietario.nombre',
            'descripcion',
            [
                'label' => 'Nº Usuarios',
                'attribute' => 'n_usuarios',
                'value' => function ($data) {
                    return $data->usuarios . '/' . $data->n_max;
                },
            ],
            'created_at:relativetime',

            [
                'class' => ActionColumn::className(),
                'template' => '{unirse}',
                'buttons' => [
                    'unirse' => function ($url, $model, $key) {
                        return Html::a(
                            'Unirse',
                            [
                                'salas/view',
                                'id' => $model->id
                            ],
                            ['class' => 'btn btn-xs btn-info']
                        );
                    },
                ]
            ],
        ],
    ]); ?>
</div>
