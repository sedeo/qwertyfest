<?php

use app\models\Informes;

use yii\web\View;

use yii\grid\ActionColumn;

use yii\helpers\Html;
use yii\grid\GridView;

use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
$columns = ['nombre'];
if (Yii::$app->user->identity->admin) {
    $columns = array_merge($columns, ['email', 'direccion', 'fec_nac', 'telefono', 'admin', 'created_at:datetime']);
}
$columns[] = [
    'class' => ActionColumn::className(),
    'header' => 'Acciones',
    'template' => '{view}{report}',
    'buttons' => [
        'view' => function ($url, $model, $key) {
            return Html::a('Ver perfil', ['usuarios/view', 'id' => $model->id], ['class' => 'btn btn-xs btn-info']);
        },
        'report' => function ($url, $model, $key) {
            if ($model->id !== Yii::$app->user->id){
                return Html::button('Reportar', [
                    'id' => $model->id,
                    'class' => 'boton-reportar btn btn-xs btn-danger',
                    'data-toggle' => 'modal',
                    'data-target' => '#ventana-modal'
                ]);
            }
        }
    ]
];
$js = <<<EOT
$('.boton-reportar').on('click', function(){
    console.log($(this).attr('id'));
    $('#informes-recibe_id').val($(this).attr('id'));
});
EOT;
$this->registerJs($js, View::POS_END);
?>
<div class="usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => $columns,
    ]); ?>
</div>

<?php Modal::begin(['id' => 'ventana-modal', 'header' => 'Crear informe']) ?>
    <?= $this->render('/informes/create', ['model' => new Informes()]) ?>
<?php Modal::end() ?>
