<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property integer $id
 * @property integer $cantidad
 * @property string $fecha
 * @property integer $idUsuario
 * @property integer $idProducto
 * @property integer $idComercio
 *
 * @property ComercioPedidos[] $comercioPedidos
 * @property Comercio $idComercio0
 * @property Producto $idProducto0
 * @property User $idUsuario0
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad', 'fecha', 'idUsuario', 'idProducto', 'idComercio'], 'required'],
            [['cantidad', 'idUsuario', 'idProducto', 'idComercio'], 'integer'],
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
            'cantidad' => Yii::t('app', 'Cantidad'),
            'fecha' => Yii::t('app', 'Fecha'),
            'idUsuario' => Yii::t('app', 'Id Usuario'),
            'idProducto' => Yii::t('app', 'Id Producto'),
            'idComercio' => Yii::t('app', 'Id Comercio'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComercioPedidos()
    {
        return $this->hasMany(ComercioPedidos::className(), ['idPedido' => 'id']);
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
    public function getIdProducto0()
    {
        return $this->hasOne(Producto::className(), ['id' => 'idProducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(User::className(), ['id' => 'idUsuario']);
    }
}
