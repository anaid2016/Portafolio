<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Videos;

/**
 * VideosSearch represents the model behind the search form of `app\models\Videos`.
 */
class VideosSearch extends Videos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_videos', 'sessions_id'], 'integer'],
            [['alias_video', 'text_video', 'scriptvideo', 'dateload'], 'safe'],
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
        $query = Videos::find();

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
            'id_videos' => $this->id_videos,
            'dateload' => $this->dateload,
            'sessions_id' => $this->sessions_id,
        ]);

        $query->andFilterWhere(['ilike', 'alias_video', $this->alias_video])
            ->andFilterWhere(['ilike', 'text_video', $this->text_video])
            ->andFilterWhere(['ilike', 'scriptvideo', $this->scriptvideo]);

        return $dataProvider;
    }
}
