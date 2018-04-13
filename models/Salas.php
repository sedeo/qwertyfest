<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "salas".
 *
 * @property int $id
 * @property int $propietario_id
 * @property string $n_max
 * @property string $descripcion
 * @property string $usuarios
 * @property string $created_at
 *
 * @property Usuarios $propietario
 */
class Salas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['propietario_id'], 'default', 'value' => null],
            [['propietario_id'], 'integer'],
            [['n_max'], 'required'],
            [['n_max', 'usuarios'], 'number'],
            [['created_at'], 'safe'],
            [['descripcion'], 'string', 'max' => 255],
            [['propietario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['propietario_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('current_timestamp(0)'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'propietario_id' => 'Propietario',
            'n_max' => 'N Max',
            'descripcion' => 'Descripción',
            'usuarios' => 'Usuarios',
            'created_at' => 'Creado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropietario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'propietario_id'])->inverseOf('salas');
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->propietario_id = Yii::$app->user->id;
                $this->usuarios = 1;
            }
            return true;
        }
        return false;
    }
}
