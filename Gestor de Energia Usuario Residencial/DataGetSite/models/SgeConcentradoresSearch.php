<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SgeConcentradores;

/**
 * SgeConcentradoresSearch represents the model behind the search form of `app\models\SgeConcentradores`.
 */
class SgeConcentradoresSearch extends SgeConcentradores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['concentrador_id', 'proyecto_id'], 'integer'],
            [['alias_concentrador', 'serial_concentrador', 'ip'], 'safe'],
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
        $query = SgeConcentradores::find();

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
            'concentrador_id' => $this->concentrador_id,
            'proyecto_id' => $this->proyecto_id,
        ]);

        $query->andFilterWhere(['ilike', 'alias_concentrador', $this->alias_concentrador])
            ->andFilterWhere(['ilike', 'serial_concentrador', $this->serial_concentrador])
            ->andFilterWhere(['ilike', 'ip', $this->ip]);

        return $dataProvider;
    }
}
