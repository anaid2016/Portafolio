<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SgeCircuitos;

/**
 * SgeCircuitosSearch represents the model behind the search form of `app\models\SgeCircuitos`.
 */
class SgeCircuitosSearch extends SgeCircuitos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['circuitos_id', 'estado_id', 'concentrador_id','numerico'], 'integer'],
            [['alias', 'fecha_creado', 'fecha_modificador'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = SgeCircuitos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'circuitos_id' => $this->circuitos_id,
            'fecha_creado' => $this->fecha_creado,
            'fecha_modificador' => $this->fecha_modificador,
            'estado_id' => $this->estado_id,
            'concentrador_id' => $this->concentrador_id,
            'numerico' => $this->numerico,
        ]);

        $query->andFilterWhere(['ilike', 'alias', $this->alias]);

        return $dataProvider;
    }
}
