<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SgeProyectos;

/**
 * SgeProyectosSearch represents the model behind the search form of `app\models\SgeProyectos`.
 */
class SgeProyectosSearch extends SgeProyectos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proyecto_id', 'usuario_id'], 'integer'],
            [['nombre_proyecto', 'fecha_creado', 'fecha_modificado'], 'safe'],
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
        $query = SgeProyectos::find();

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
            'proyecto_id' => $this->proyecto_id,
            'fecha_creado' => $this->fecha_creado,
            'fecha_modificado' => $this->fecha_modificado,
            'usuario_id' => $this->usuario_id,
        ]);

        $query->andFilterWhere(['ilike', 'nombre_proyecto', $this->nombre_proyecto]);

        return $dataProvider;
    }
}
