<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sge_tipo_medidor".
 *
 * @property int $tipo_medidor_id
 * @property string|null $alias_tipo_medidor
 * @property string|null $marca
 *
 * @property SgeMedidores[] $sgeMedidores
 */
class SgeTipoMedidor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_tipo_medidor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_medidor_id'], 'required'],
            [['tipo_medidor_id'], 'default', 'value' => null],
            [['tipo_medidor_id'], 'integer'],
            [['alias_tipo_medidor', 'marca'], 'string', 'max' => 255],
            [['tipo_medidor_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tipo_medidor_id' => 'Tipo Medidor ID',
            'alias_tipo_medidor' => 'Alias Tipo Medidor',
            'marca' => 'Marca',
        ];
    }

    /**
     * Gets query for [[SgeMedidores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSgeMedidores()
    {
        return $this->hasMany(SgeMedidores::className(), ['tipo_medidor_id' => 'tipo_medidor_id']);
    }
}
