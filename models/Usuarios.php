<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
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
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ESCENARIO_CREATE = 'create';
    const ESCENARIO_UPDATE = 'update';

    public $conf_pass;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['conf_pass']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email'], 'required'],
            [['password', 'conf_pass'], 'required', 'on' => self::ESCENARIO_CREATE],
            [
                 ['conf_pass'],
                 'compare',
                 'compareAttribute' => 'password',
                 'skipOnEmpty' => false,
                 'on' => [self::ESCENARIO_CREATE, self::ESCENARIO_UPDATE],
             ],
            [['created_at'], 'safe'],
            [['fec_nac'], 'date'],
            [['telefono'], 'number'],
            [['email'], 'email'],
            [['admin'], 'boolean'],
            [['nombre', 'password', 'auth_key', 'token_val', 'direccion'], 'string', 'max' => 255],
            [['nombre', 'token_val'], 'unique'],
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
            'nombre' => 'Nombre de usuario',
            'email' => 'Email',
            'password' => 'Contraseña',
            'conf_pass' => 'Confirmar contraseña',
            'auth_key' => 'Auth Key',
            'token_val' => 'Token Val',
            'direccion' => 'Dirección',
            'fec_nac' => 'Fecha de nacimiento',
            'telefono' => 'Teléfono',
            'admin' => 'Admin',
            'created_at' => 'Fecha de creación',
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

    public function emailVerificar()
    {
        $resultado = Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject('Validación de tu cuenta de email')
            ->setHtmlBody(Html::a('Haga click aqui para verificar', Url::to(['usuarios/verificar', 'token_val' => $this->token_val], true)))
            ->send();
        Yii::$app->session->setFlash('info', 'Se le ha enviado un correo de verificación');
    }

    public function emailPassword($id, $password)
    {
        $resultado = Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($this->email)
            ->setSubject('Validación de cambio de contraseña')
            ->setHtmlBody(Html::a(
                'Haga click aqui para hacer efectivo el cambio de contraseña',
                Url::to([
                    'usuarios/cambiar-password',
                    'id' => $id,
                    'password' => $password,
                ], true)
            ))
            ->send();
        Yii::$app->session->setFlash('info', 'Se le ha enviado un correo de confirmación.');
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @param null|mixed $type
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->token_val = Yii::$app->security->generateRandomString();
                if ($this->scenario === self::ESCENARIO_CREATE) {
                    $this->password = Yii::$app->security->generatePasswordHash($this->password);
                }
            } else {
                if ($this->scenario === self::ESCENARIO_UPDATE) {
                    if ($this->password !== '') {
                        self::emailPassword($this->id, Yii::$app->security->generatePasswordHash($this->password));
                        $this->password = $this->getOldAttribute('password');
                    }
                }
            }
            return true;
        }
        return false;
    }
}
