<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property CategoriaProductos[] $categoriaProductos
 * @property Producto[] $productos
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriaProductos()
    {
        return $this->hasMany(CategoriaProductos::className(), ['idCategoria' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['idCategoria' => 'id']);
    }
}
