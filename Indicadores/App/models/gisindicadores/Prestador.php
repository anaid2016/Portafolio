<?php

namespace app\models\gisindicadores;

use Yii;

/**
 * This is the model class for table "prestador".
 *
 * @property int $cod_prestador
 * @property string|null $nombre
 * @property int|null $tipo
 * @property string|null $estado
 * @property string|null $fecha_desde
 * @property string|null $fecha_hasta
 *
 * @property Hechos[] $hechos
 * @property LocalizacionPrestador[] $localizacionPrestadors
 * @property Localizacion[] $codLocalizacions
 */
class Prestador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prestador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cod_prestador'], 'required'],
            [['cod_prestador', 'tipo'], 'default', 'value' => null],
            [['cod_prestador', 'tipo'], 'integer'],
            [['fecha_desde', 'fecha_hasta'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
            [['estado'], 'string', 'max' => 1],
            [['cod_prestador'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cod_prestador' => 'Cod Prestador',
            'nombre' => 'Nombre',
            'tipo' => 'Tipo',
            'estado' => 'Estado',
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
        ];
    }

    /**
     * Gets query for [[Hechos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHechos()
    {
        return $this->hasMany(Hechos::className(), ['cod_prestador' => 'cod_prestador']);
    }

    /**
     * Gets query for [[LocalizacionPrestadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacionPrestadors()
    {
        return $this->hasMany(LocalizacionPrestador::className(), ['cod_prestador' => 'cod_prestador']);
    }

    /**
     * Gets query for [[CodLocalizacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodLocalizacions()
    {
        return $this->hasMany(Localizacion::className(), ['cod_localizacion' => 'cod_localizacion'])->viaTable('localizacion_prestador', ['cod_prestador' => 'cod_prestador']);
    }
}
