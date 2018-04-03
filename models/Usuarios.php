<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $password
 * @property string $auth_key
 * @property string $token_val
 * @property string $direccion
 * @property string $fec_nac
 * @property string $telefono
 * @property bool $admin
 * @property string $created_at
 *
 * @property Informes[] $informes
 * @property Informes[] $informes0
 * @property Salas[] $salas
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'password', 'created_at'], 'required'],
            [['fec_nac', 'created_at'], 'safe'],
            [['telefono'], 'number'],
            [['admin'], 'boolean'],
            [['nombre', 'password', 'auth_key', 'token_val', 'direccion'], 'string', 'max' => 255],
            [['token_val'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'token_val' => 'Token Val',
            'direccion' => 'Direccion',
            'fec_nac' => 'Fec Nac',
            'telefono' => 'Telefono',
            'admin' => 'Admin',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformes()
    {
        return $this->hasMany(Informes::className(), ['id_recibe' => 'id'])->inverseOf('recibe');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformes0()
    {
        return $this->hasMany(Informes::className(), ['id_envia' => 'id'])->inverseOf('envia');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalas()
    {
        return $this->hasMany(Salas::className(), ['propietario' => 'id'])->inverseOf('propietario0');
    }
}
