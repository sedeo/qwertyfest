<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "informes".
 *
 * @property int $id
 * @property int $id_recibe
 * @property int $id_envia
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
            [['id_recibe', 'id_envia'], 'default', 'value' => null],
            [['id_recibe', 'id_envia'], 'integer'],
            [['motivo', 'created_at'], 'required'],
            [['created_at'], 'safe'],
            [['motivo', 'descripcion'], 'string', 'max' => 255],
            [['id_recibe'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_recibe' => 'id']],
            [['id_envia'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_envia' => 'id']],
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
            'id_recibe' => 'Id Recibe',
            'id_envia' => 'Id Envia',
            'motivo' => 'Motivo',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibe()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_recibe'])->inverseOf('informes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnvia()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_envia'])->inverseOf('informes0');
    }
}
