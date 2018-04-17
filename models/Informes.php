<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "informes".
 *
 * @property int $id
 * @property int $recibe_id
 * @property int $envia_id
 * @property string $motivo
 * @property string $descripcion
 * @property string $created_at
 *
 * @property Usuarios $recibe
 * @property Usuarios $envia
 */
class Informes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'informes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['recibe_id', 'envia_id'], 'default', 'value' => null],
            [['recibe_id', 'envia_id'], 'integer'],
            [['motivo'], 'required'],
            [['created_at'], 'safe'],
            [['motivo', 'descripcion'], 'string', 'max' => 255],
            [['recibe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['recibe_id' => 'id']],
            [['envia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['envia_id' => 'id']],
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
            'recibe_id' => 'Enviado a',
            'envia_id' => 'Enviado por',
            'motivo' => 'Motivo',
            'descripcion' => 'Descripción',
            'created_at' => 'Fecha de creación',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibe()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'recibe_id'])->inverseOf('informes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnvia()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'envia_id'])->inverseOf('informes0');
    }
}
