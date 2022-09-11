<?php

namespace app\models\gisindicadores;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\gisindicadores\Glosario;

/**
 * GlosarioSearch representa el modelo detras del formulario de busqueda para `app\models\gisindicadores\Glosario`.
 */
class GlosarioSearch extends Glosario
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cod_glosario'], 'integer'],
            [['nombre', 'descripcion'], 'safe'],
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
        $query = Glosario::find();

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
            'cod_glosario' => $this->cod_glosario,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
