<?php

namespace app\models\gisindicadores;

use Yii;

/**
 * This is the model class for table "hechos".
 *
 * @property int $cod_hechos
 * @property int|null $anio
 * @property int|null $cod_indi_param
 * @property int|null $cod_prestador
 * @property int|null $cod_localizacion
 * @property float|null $valor
 * @property int|null $consecutivocarga
 *
 * @property IndicadorParametro $codIndiParam
 * @property Localizacion $codLocalizacion
 * @property LogCarga $consecutivocarga0
 * @property Prestador $codPrestador
 */
class Hechos extends \yii\db\ActiveRecord
{
    public $labelsgraf;
    public $valoresgraf;
    public $periodo;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hechos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cod_hechos'], 'required'],
            [['cod_hechos', 'anio', 'cod_indi_param', 'cod_prestador', 'cod_localizacion', 'consecutivocarga'], 'default', 'value' => null],
            [['cod_hechos', 'anio', 'cod_indi_param', 'cod_prestador', 'cod_localizacion', 'consecutivocarga'], 'integer'],
            [['valor'], 'number'],
            [['cod_hechos'], 'unique'],
            [['cod_indi_param'], 'exist', 'skipOnError' => true, 'targetClass' => IndicadorParametro::className(), 'targetAttribute' => ['cod_indi_param' => 'cod_indi_param']],
            [['cod_localizacion'], 'exist', 'skipOnError' => true, 'targetClass' => Localizacion::className(), 'targetAttribute' => ['cod_localizacion' => 'cod_localizacion']],
            [['consecutivocarga'], 'exist', 'skipOnError' => true, 'targetClass' => LogCarga::className(), 'targetAttribute' => ['consecutivocarga' => 'consecutivocarga']],
            [['cod_prestador'], 'exist', 'skipOnError' => true, 'targetClass' => Prestador::className(), 'targetAttribute' => ['cod_prestador' => 'cod_prestador']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cod_hechos' => 'Cod Hechos',
            'anio' => 'Anio',
            'cod_indi_param' => 'Cod Indi Param',
            'cod_prestador' => 'Cod Prestador',
            'cod_localizacion' => 'Cod Localizacion',
            'valor' => 'Valor',
            'consecutivocarga' => 'Consecutivocarga',
        ];
    }

    /**
     * Gets query for [[CodIndiParam]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodIndiParam()
    {
        return $this->hasOne(IndicadorParametro::className(), ['cod_indi_param' => 'cod_indi_param']);
    }

    /**
     * Gets query for [[CodLocalizacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodLocalizacion()
    {
        return $this->hasOne(Localizacion::className(), ['cod_localizacion' => 'cod_localizacion']);
    }

    /**
     * Gets query for [[Consecutivocarga0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConsecutivocarga0()
    {
        return $this->hasOne(LogCarga::className(), ['consecutivocarga' => 'consecutivocarga']);
    }

    /**
     * Gets query for [[CodPrestador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodPrestador()
    {
        return $this->hasOne(Prestador::className(), ['cod_prestador' => 'cod_prestador']);
    }
}
