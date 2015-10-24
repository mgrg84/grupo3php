<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comercio_pedidos".
 *
 * @property integer $id
 * @property integer $idComercio
 * @property integer $idPedido
 *
 * @property Comercio $idComercio0
 * @property Pedido $idPedido0
 */
class ComercioPedidos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercio_pedidos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idComercio', 'idPedido'], 'required'],
            [['idComercio', 'idPedido'], 'integer']
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
            'idPedido' => 'Id Pedido',
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
    public function getIdPedido0()
    {
        return $this->hasOne(Pedido::className(), ['id' => 'idPedido']);
    }
}
