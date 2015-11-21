<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ruta".
 *
 * @property integer $id
 * @property integer $idUsuario
 * @property string $fecha
 *
 * @property User $Usuario
 * @property RutaComercios[] $rutaComercios
 */

class Ruta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ruta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUsuario', 'fecha'], 'required'],
            [['idUsuario'], 'integer'],
            [['fecha'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idUsuario' => Yii::t('app', 'Id Usuario'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasOne(User::className(), ['id' => 'idUsuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutaComercios()
    {
        return $this->hasMany(RutaComercios::className(), ['idRuta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRutas()
    {
        return $this->hasMany(UserRutas::className(), ['idRuta' => 'id']);
    }
}
