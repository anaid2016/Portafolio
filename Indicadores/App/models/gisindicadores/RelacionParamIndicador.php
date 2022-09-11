<?php

namespace app\models\gisindicadores;

use Yii;

/**
 * This is the model class for table "relacion_param_indicador".
 *
 * @property int $cod_indicador
 * @property int $cod_parametro
 * @property string|null $estado
 * @property string|null $fecha_desde
 * @property string|null $fecha_hasta
 *
 * @property IndicadorParametro $codIndicador
 * @property IndicadorParametro $codParametro
 */
class RelacionParamIndicador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relacion_param_indicador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cod_indicador', 'cod_parametro'], 'required'],
            [['cod_indicador', 'cod_parametro'], 'default', 'value' => null],
            [['cod_indicador', 'cod_parametro'], 'integer'],
            [['fecha_desde', 'fecha_hasta'], 'safe'],
            [['estado'], 'string', 'max' => 1],
            [['cod_indicador', 'cod_parametro'], 'unique', 'targetAttribute' => ['cod_indicador', 'cod_parametro']],
            [['cod_indicador'], 'exist', 'skipOnError' => true, 'targetClass' => IndicadorParametro::className(), 'targetAttribute' => ['cod_indicador' => 'cod_indi_param']],
            [['cod_parametro'], 'exist', 'skipOnError' => true, 'targetClass' => IndicadorParametro::className(), 'targetAttribute' => ['cod_parametro' => 'cod_indi_param']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cod_indicador' => 'Cod Indicador',
            'cod_parametro' => 'Cod Parametro',
            'estado' => 'Estado',
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
        ];
    }

    /**
     * Gets query for [[CodIndicador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodIndicador()
    {
        return $this->hasOne(IndicadorParametro::className(), ['cod_indi_param' => 'cod_indicador']);
    }

    /**
     * Gets query for [[CodParametro]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodParametro()
    {
        return $this->hasOne(IndicadorParametro::className(), ['cod_indi_param' => 'cod_parametro']);
    }
}
