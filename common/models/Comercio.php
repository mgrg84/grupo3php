<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comercio".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $ubicacion
 * @property integer $prioridad
 * @property integer $lunes
 * @property integer $martes
 * @property integer $miercoles
 * @property integer $jueves
 * @property integer $viernes
 * @property integer $sabado
 * @property integer $domingo
 * @property string $horario_desde
 * @property string $horario_hasta
 * @property string $ubicacion_descripcion
 *
 * @property ComercioPedidos[] $comercioPedidos
 * @property ComercioStocks[] $comercioStocks
 * @property Pedido[] $pedidos
 * @property RutaComercios[] $rutaComercios
 * @property Stock[] $stocks
 */
class Comercio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'ubicacion', 'prioridad', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'horario_desde', 'horario_hasta'], 'required'],
            [['nombre', 'ubicacion', 'ubicacion_descripcion'], 'string'],
            [['prioridad', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'], 'integer'],
            [['horario_desde', 'horario_hasta'], 'safe']
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
            'ubicacion' => Yii::t('app', 'Ubicacion'),
            'prioridad' => Yii::t('app', 'Prioridad'),
            'lunes' => Yii::t('app', 'Lunes'),
            'martes' => Yii::t('app', 'Martes'),
            'miercoles' => Yii::t('app', 'Miercoles'),
            'jueves' => Yii::t('app', 'Jueves'),
            'viernes' => Yii::t('app', 'Viernes'),
            'sabado' => Yii::t('app', 'Sabado'),
            'domingo' => Yii::t('app', 'Domingo'),
            'horario_desde' => Yii::t('app', 'Horario Desde'),
            'horario_hasta' => Yii::t('app', 'Horario Hasta'),
            'ubicacion_descripcion' => Yii::t('app', 'Ubicacion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComercioPedidos()
    {
        return $this->hasMany(ComercioPedidos::className(), ['idComercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComercioStocks()
    {
        return $this->hasMany(ComercioStocks::className(), ['idComercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['idComercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutaComercios()
    {
        return $this->hasMany(RutaComercios::className(), ['idComercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['idComercio' => 'id']);
    }
}
