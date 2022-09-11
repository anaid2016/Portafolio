<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SgeSureusuarios;

/**
 * SgeSureusuariosSearch represents the model behind the search form of `app\models\SgeSureusuarios`.
 */
class SgeSureusuariosSearch extends SgeSureusuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'estado_id', 'medidor_id'], 'integer'],
            [['nombre_usuario', 'correo_electronico', 'serwmpskey', 'setwmpskey_hash', 'setauthkey', 'setps_reset_token', 'hab_us_token_forzada'], 'safe'],
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
        $query = SgeSureusuarios::find();

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
            'usuario_id' => $this->usuario_id,
            'estado_id' => $this->estado_id,
            'medidor_id' => $this->medidor_id,
        ]);

        $query->andFilterWhere(['ilike', 'nombre_usuario', $this->nombre_usuario])
            ->andFilterWhere(['ilike', 'correo_electronico', $this->correo_electronico])
            ->andFilterWhere(['ilike', 'serwmpskey', $this->serwmpskey])
            ->andFilterWhere(['ilike', 'setwmpskey_hash', $this->setwmpskey_hash])
            ->andFilterWhere(['ilike', 'setauthkey', $this->setauthkey])
            ->andFilterWhere(['ilike', 'setps_reset_token', $this->setps_reset_token])
            ->andFilterWhere(['ilike', 'hab_us_token_forzada', $this->hab_us_token_forzada]);

        return $dataProvider;
    }
}
