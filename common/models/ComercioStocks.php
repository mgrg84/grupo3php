<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comercio_stocks".
 *
 * @property integer $id
 * @property integer $idComercio
 * @property integer $idStock
 *
 * @property Comercio $idComercio0
 * @property Stock $idStock0
 */
class ComercioStocks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercio_stocks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idComercio', 'idStock'], 'required'],
            [['idComercio', 'idStock'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idComercio' => 'Id Comercio',
            'idStock' => 'Id Stock',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComercio0()
    {
        return $this->hasOne(Comercio::className(), ['id' => 'idComercio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStock0()
    {
        return $this->hasOne(Stock::className(), ['id' => 'idStock']);
    }
}
