<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $imagen
 * @property integer $idCategoria
 *
 * @property CategoriaProductos[] $categoriaProductos
 * @property Pedido[] $pedidos
 * @property Categoria $idCategoria0
 * @property Stock[] $stocks
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'imagen', 'idCategoria'], 'required'],
            [['nombre', 'imagen'], 'string'],
            [['idCategoria'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'imagen' => Yii::t('app', 'Imagen'),
            'idCategoria' => Yii::t('app', 'Id Categoria'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaProductos()
    {
        return $this->hasMany(CategoriaProductos::className(), ['idProducto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['idProducto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria0()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'idCategoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['idProducto' => 'id']);
    }
}
