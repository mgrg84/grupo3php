<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "ruta_comercios".
 *
 * @property integer $id
 * @property integer $idRuta
 * @property integer $idComercio
 * @property integer $recorrido
 *
 * @property Comercio $Comercio
 * @property Ruta $Ruta
 */
class RutaComercios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ruta_comercios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idRuta', 'idComercio'], 'required'],
            [['idRuta', 'idComercio', 'recorrido'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'idRuta' => Yii::t('app', 'Id Ruta'),
            'idComercio' => Yii::t('app', 'Id Comercio'),
            'recorrido' => Yii::t('app', 'Recorrido'),
        ];
    }

	public function fields()
	{
		return [
			'id',
			'recorrido',
			'comercio' => function ($model)
			{
				return $model->comercio; // Return related model property, correct according to your structure
			},
		];
	}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComercio()
    {
        return $this->hasOne(Comercio::className(), ['id' => 'idComercio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuta()
    {
        return $this->hasOne(Ruta::className(), ['id' => 'idRuta']);
    }
}
