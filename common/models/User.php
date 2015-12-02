<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $confirmed_at
 * @property string $unconfirmed_email
 * @property integer $blocked_at
 * @property string $registration_ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flags
 * @property string $ubicacionDomicilio
 *
 * @property Pedido[] $pedidos
 * @property Profile $profile
 * @property Ruta[] $rutas
 * @property SocialAccount[] $socialAccounts
 * @property Stock[] $stocks
 * @property Token[] $tokens
 * @property UserRutas[] $userRutas
 */
class User extends \yii\db\ActiveRecord
{
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'auth_key', 'created_at', 'updated_at', 'ubicacionDomicilio'], 'required'],
            [['confirmed_at', 'blocked_at', 'created_at', 'updated_at', 'flags'], 'integer'],
            [['ubicacionDomicilio'], 'string'],
            [['username', 'email', 'unconfirmed_email'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['registration_ip'], 'string', 'max' => 45],
            [['email'], 'unique'],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'confirmed_at' => Yii::t('app', 'Confirmed At'),
            'unconfirmed_email' => Yii::t('app', 'Unconfirmed Email'),
            'blocked_at' => Yii::t('app', 'Blocked At'),
            'registration_ip' => Yii::t('app', 'Registration Ip'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'flags' => Yii::t('app', 'Flags'),
            'ubicacionDomicilio' => Yii::t('app', 'Ubicacion Domicilio'),
            //'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

	public function getComerciosRecorridos()
    {
		$rutasRecorridos = $this->getRutas()
			->joinWith('rutaComercios')
			->count()
		;
		
		return $comerciosRecorridos = $this->getRutas()
			->joinWith('rutaComercios')
			->sum('ruta_Comercios.recorrido')
		;
		if($comerciosRecorridos == 0)
		{
			return 0;		
		}
		else
		{
			return ($comerciosRecorridos * 100) / $rutasRecorridos;
		}
    }
	
	public function getComerciosAsignados()
	{
		return $this->getRutas()
			->joinWith('rutaComercios')
			->count()
		;
	}
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['idUsuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutas()
    {
        return $this->hasMany(Ruta::className(), ['idUsuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialAccounts()
    {
        return $this->hasMany(SocialAccount::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['idUsuario' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Token::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRutas()
    {
        return $this->hasMany(UserRutas::className(), ['idUsuario' => 'id']);
    }
}
