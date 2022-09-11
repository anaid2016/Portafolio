<?php

namespace app\models\gisindicadores;

use Yii;

/**
 * This is the model class for table "localizacion_prestador".
 *
 * @property int $cod_prestador
 * @property int $cod_localizacion
 * @property int|null $numero_beneficiarios
 * @property string|null $estado
 * @property string|null $fecha_desde
 * @property string|null $fecha_hasta
 *
 * @property Localizacion $codLocalizacion
 * @property Prestador $codPrestador
 */
class LocalizacionPrestador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'localizacion_prestador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cod_prestador', 'cod_localizacion'], 'required'],
            [['cod_prestador', 'cod_localizacion', 'numero_beneficiarios'], 'default', 'value' => null],
            [['cod_prestador', 'cod_localizacion', 'numero_beneficiarios'], 'integer'],
            [['fecha_desde', 'fecha_hasta'], 'safe'],
            [['estado'], 'string', 'max' => 1],
            [['cod_prestador', 'cod_localizacion'], 'unique', 'targetAttribute' => ['cod_prestador', 'cod_localizacion']],
            [['cod_localizacion'], 'exist', 'skipOnError' => true, 'targetClass' => Localizacion::className(), 'targetAttribute' => ['cod_localizacion' => 'cod_localizacion']],
            [['cod_prestador'], 'exist', 'skipOnError' => true, 'targetClass' => Prestador::className(), 'targetAttribute' => ['cod_prestador' => 'cod_prestador']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cod_prestador' => 'Cod Prestador',
            'cod_localizacion' => 'Cod Localizacion',
            'numero_beneficiarios' => 'Numero Beneficiarios',
            'estado' => 'Estado',
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
        ];
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
     * Gets query for [[CodPrestador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodPrestador()
    {
        return $this->hasOne(Prestador::className(), ['cod_prestador' => 'cod_prestador']);
    }
}
