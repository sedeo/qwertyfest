<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "salas".
 *
 * @property int $id
 * @property int $propietario
 * @property string $n_max
 * @property string $descripcion
 * @property string $usuarios
 * @property string $created_at
 *
 * @property Usuarios $propietario0
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
            [['propietario'], 'default', 'value' => null],
            [['propietario'], 'integer'],
            [['n_max', 'created_at'], 'required'],
            [['n_max', 'usuarios'], 'number'],
            [['created_at'], 'safe'],
            [['descripcion'], 'string', 'max' => 255],
            [['propietario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['propietario' => 'id']],
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
            'propietario' => 'Propietario',
            'n_max' => 'N Max',
            'descripcion' => 'Descripcion',
            'usuarios' => 'Usuarios',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropietario0()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'propietario'])->inverseOf('salas');
    }
}
