<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sessions;

/**
 * SessionsSearch represents the model behind the search form of `app\models\Sessions`.
 */
class SessionsSearch extends Sessions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_session'], 'integer'],
            [['alias_sesion', 'datetimecreate'], 'safe'],
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
        $query = Sessions::find();

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
            'id_session' => $this->id_session,
            'datetimecreate' => $this->datetimecreate,
        ]);

        $query->andFilterWhere(['ilike', 'alias_sesion', $this->alias_sesion]);

        return $dataProvider;
    }
}
