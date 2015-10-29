<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comercio;

/**
 * ComercioSearch represents the model behind the search form about `common\models\Comercio`.
 */
class ComercioSearch extends Comercio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prioridad', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'], 'integer'],
            [['nombre', 'ubicacion', 'horario_desde', 'horario_hasta'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comercio::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'prioridad' => $this->prioridad,
            'lunes' => $this->lunes,
            'martes' => $this->martes,
            'miercoles' => $this->miercoles,
            'jueves' => $this->jueves,
            'viernes' => $this->viernes,
            'sabado' => $this->sabado,
            'domingo' => $this->domingo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'ubicacion', $this->ubicacion])
        ;

        return $dataProvider;
    }
}
