<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sge_lecturas".
 *
 * @property int $registro_lectura_id
 * @property string|null $fecha_hora_registro
 * @property int|null $medidor_id
 * @property float|null $tensionfaseA Tensión Fase A [V]
 * @property float|null $tensionfaseB Tensión Fase B [V]
 * @property float|null $tensionfaseC Tensión Fase C [V]
 * @property float|null $corrientefaseA Corriente Fase A [A]
 * @property float|null $corrientefaseB Corriente Fase B [A]
 * @property float|null $corrientefaseC Corriente Fase C [A]
 * @property float|null $activainsfaseA Activa Ins. Fase A [W]
 * @property float|null $activainsfaseB Activa Ins. Fase B [W]
 * @property float|null $activainsfaseC Activa Ins. Fase C [W]
 * @property float|null $activainstotal Activa Total [W]
 * @property float|null $reactivainstotal Reactiva Total [VAR]
 * @property string|null $estado_rele '0'.->Apagado, '1'->Encendido, -1 'Desconocida'
 * @property float|null $energia_activa contador energia activa
 * @property float|null $energia_reactiva contador energia reactiva
 * @property float|null $fpfaseA FP Fase A
 * @property float|null $fpfaseB FP Fase B
 * @property float|null $fpfaseC FP Fase C
 * @property float|null $frecuencia Frecuencia [Hz]
 * @property string|null $fecha_hora_ingreso
 *
 * @property SgeMedidores $medidor
 */
class SgeLecturas extends \yii\db\ActiveRecord
{
    public $cto;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_lecturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_hora_registro', 'fecha_hora_ingreso'], 'safe'],
            [['medidor_id'], 'default', 'value' => null],
            [['medidor_id'], 'integer'],
            [['tensionfaseA', 'tensionfaseB', 'tensionfaseC', 'corrientefaseA', 'corrientefaseB', 'corrientefaseC', 'activainsfaseA', 'activainsfaseB', 'activainsfaseC', 'activainstotal', 'reactivainstotal', 'energia_activa', 'energia_reactiva', 'fpfaseA', 'fpfaseB', 'fpfaseC', 'frecuencia'], 'number'],
            [['estado_rele'], 'string', 'max' => 1],
            [['medidor_id'], 'exist', 'skipOnError' => true, 'targetClass' => SgeMedidores::className(), 'targetAttribute' => ['medidor_id' => 'medidor_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'registro_lectura_id' => 'Registro Lectura ID',
            'fecha_hora_registro' => 'Fecha Hora Registro',
            'medidor_id' => 'Medidor ID',
            'tensionfaseA' => 'Fase A [V]',
            'tensionfaseB' => 'Fase B [V]',
            'tensionfaseC' => 'Fase C [V]',
            'corrientefaseA' => 'Fase A [A]',
            'corrientefaseB' => 'Fase B [A]',
            'corrientefaseC' => 'Fase C [A]',
            'activainsfaseA' => 'Fase A [kW]',
            'activainsfaseB' => 'Fase B [kW]',
            'activainsfaseC' => 'Fase C [kW]',
            'activainstotal' => 'Potencia [kwh]',
            'reactivainstotal' => 'Potencia [kVAr]',
            'estado_rele' => 'Estado Rele',
            'energia_activa' => 'Energia Activa',
            'energia_reactiva' => 'Energia Reactiva',
            'fpfaseA' => 'Fpfase A',
            'fpfaseB' => 'Fpfase B',
            'fpfaseC' => 'Fpfase C',
            'frecuencia' => 'Frecuencia',
            'fecha_hora_ingreso' => 'Fecha Hora Ingreso',
        ];
    }

    /**
     * Gets query for [[Medidor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedidor()
    {
        return $this->hasOne(SgeMedidores::className(), ['medidor_id' => 'medidor_id']);
    }
}
