<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SgeMedidores;

/**
 * SgeMedidoresSearch represents the model behind the search form of `app\models\SgeMedidores`.
 */
class SgeMedidoresSearch extends SgeMedidores
{
    public $proyecto_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['medidor_id', 'circuito_id', 'estado_id','proyecto_id'], 'integer'],
            [['modbusposition'], 'number'],
            [['serial', 'fecha_creado', 'fecha_modificado'], 'safe'],
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
        $query = SgeMedidores::find()
                ->leftJoin('sge_circuitos', 'sge_circuitos.circuitos_id = sge_medidores.circuito_id')
                ->leftJoin('sge_concentradores', 'sge_concentradores.concentrador_id = sge_circuitos.concentrador_id')
                ->leftJoin('sge_proyectos', 'sge_proyectos.proyecto_id = sge_concentradores.proyecto_id');

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
            'medidor_id' => $this->medidor_id,
            'circuito_id' => $this->circuito_id,
            'sge_medidores.estado_id' => $this->estado_id,
            'modbusposition' => $this->modbusposition,
            'DATE(sge_medidores.fecha_creado)' => $this->fecha_creado,
            'fecha_modificado' => $this->fecha_modificado,
            'sge_proyectos.proyecto_id'=> $this->proyecto_id,
        ]);

        $query->andFilterWhere(['ilike', 'serial', $this->serial]);

        return $dataProvider;
    }
}
