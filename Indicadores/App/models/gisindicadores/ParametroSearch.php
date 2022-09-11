<?php

namespace app\models\gisindicadores;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\gisindicadores\IndicadorParametro;

/**
 * ParametroSearch representa el modelo detras del formulario de busqueda para `app\models\gisindicadores\IndicadorParametro`.
 */
class ParametroSearch extends IndicadorParametro
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cod_indi_param', 'cod_area', 'relevancia_indicador'], 'integer'],
            [['nombre', 'sigla', 'descripcion', 'formula', 'tipo', 'unidad', 'descr_relacion_param', 'estado', 'fecha_desde', 'fecha_hasta', 'tipo_dato', 'tipo_calc_parametro'], 'safe'],
            [['valor_cumplimiento'], 'number'],
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
        $query = IndicadorParametro::find();

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
            'cod_indi_param' => $this->cod_indi_param,
            'cod_area' => $this->cod_area,
            'fecha_desde' => $this->fecha_desde,
            'fecha_hasta' => $this->fecha_hasta,
            'relevancia_indicador' => $this->relevancia_indicador,
            'valor_cumplimiento' => $this->valor_cumplimiento,
        ]);

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'sigla', $this->sigla])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion])
            ->andFilterWhere(['ilike', 'formula', $this->formula])
            ->andFilterWhere(['ilike', 'tipo', $this->tipo])
            ->andFilterWhere(['ilike', 'unidad', $this->unidad])
            ->andFilterWhere(['ilike', 'descr_relacion_param', $this->descr_relacion_param])
            ->andFilterWhere(['ilike', 'estado', $this->estado])
            ->andFilterWhere(['ilike', 'tipo_dato', $this->tipo_dato])
            ->andFilterWhere(['ilike', 'tipo_calc_parametro', $this->tipo_calc_parametro]);

        return $dataProvider;
    }
}
