<?php

namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_lecturas_ongrid".
 *
 * @property int $registro_id
 * @property int|null $equipo_id
 * @property string|null $fecha_hora
 * @property string|null $fecha_insercion
 * @property int|null $modbusposition
 * @property string|null $tipo
 * @property float|null $gridv_r Voltaje de la Red, aplica al OR (V)
 * @property float|null $gridv_s Voltaje de la Red, aplica al OR (V)
 * @property float|null $gridv_t Voltaje de la Red, aplica al OR (V)
 * @property float|null $grida_r Corriente de red, aplica al INV (A)
 * @property float|null $grida_s Corriente de red, aplica al INV (A)
 * @property float|null $grida_t Corriente de red, aplica al INV (A)
 * @property float|null $f_total Frecuencia total OR
 * @property float|null $frec_r Frecuencia Fase R
 * @property float|null $frec_s Frecuencia Fase S
 * @property float|null $frec_t Frecuencia Fase T
 * @property float|null $pv_v1 Tensión paneles canal 1
 * @property float|null $pv_v2 Tensión paneles canal 2
 * @property float|null $pv_v3 Tensión paneles canal 3
 * @property float|null $pv_v4 Tensión paneles canal 4
 * @property float|null $pv_v5 Tensión paneles canal 5
 * @property float|null $pv_v6 Tensión paneles canal 6
 * @property float|null $pv_v7 Tensión paneles canal 7
 * @property float|null $pv_v8 Tensión paneles canal 8
 * @property float|null $pv_a1 Corriente panel canal 1
 * @property float|null $pv_a2 Corriente panel canal 2
 * @property float|null $pv_a3 Corriente panel canal 3
 * @property float|null $pv_a4 Corriente panel canal 4
 * @property float|null $pv_a5 Corriente panel canal 5
 * @property float|null $pv_a6 Corriente panel canal 6
 * @property float|null $pv_a7 Corriente panel canl 7
 * @property float|null $pv_a8 Corriente panel canal 8
 * @property float|null $output_p Potencia Salida Aplica al INV en W
 * @property float|null $temperatura Del INV en °C
 * @property float|null $todayE Energia Inyectada Hoy en kWh :INV
 * @property float|null $totalE Energia Inyectada total en kWh :INV
 * @property float|null $fp OR
 * @property int|null $inverter_m Modo de operacion
 * @property int|null $inverter_f Modo de fallo
 *
 * @property SfvEquipos $equipo
 * @property SfvInverterongridFail $inverterF
 * @property SfvInverterongridMode $inverterM
 */
class SfvLecturasOngrid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_lecturas_ongrid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipo_id', 'modbusposition', 'inverter_m', 'inverter_f'], 'integer'],
            ['fecha_insercion', 'safe'],
            [['fecha_hora'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['fecha_hora'], 'validateDateread'],
            [['gridv_r', 'gridv_s', 'gridv_t', 'grida_r', 'grida_s', 'grida_t', 'f_total', 'frec_r', 'frec_s', 'frec_t', 'pv_v1', 'pv_v2', 'pv_v3', 'pv_v4', 'pv_v5', 'pv_v6', 'pv_v7', 'pv_v8', 'pv_a1', 'pv_a2', 'pv_a3', 'pv_a4', 'pv_a5', 'pv_a6', 'pv_a7', 'pv_a8', 'output_p', 'temperatura', 'todayE', 'totalE', 'fp'], 'number'],
            [['tipo'], 'string', 'max' => 20],
            [['equipo_id', 'fecha_hora'], 'unique', 'targetAttribute' => ['equipo_id', 'fecha_hora']],
            [['equipo_id'],'validateTipoEquipo'],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => SfvEquipos::className(), 'targetAttribute' => ['equipo_id' => 'equipo_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'registro_id' => 'Registro ID',
            'equipo_id' => 'Equipo ID',
            'fecha_hora' => 'Fecha Hora',
            'fecha_insercion' => 'Fecha Insercion',
            'modbusposition' => 'Modbusposition',
            'tipo' => 'Tipo',
            'gridv_r' => 'Gridv R',
            'gridv_s' => 'Gridv S',
            'gridv_t' => 'Gridv T',
            'grida_r' => 'Grida R',
            'grida_s' => 'Grida S',
            'grida_t' => 'Grida T',
            'f_total' => 'F Total',
            'frec_r' => 'Frec R',
            'frec_s' => 'Frec S',
            'frec_t' => 'Frec T',
            'pv_v1' => 'Pv V1',
            'pv_v2' => 'Pv V2',
            'pv_v3' => 'Pv V3',
            'pv_v4' => 'Pv V4',
            'pv_v5' => 'Pv V5',
            'pv_v6' => 'Pv V6',
            'pv_v7' => 'Pv V7',
            'pv_v8' => 'Pv V8',
            'pv_a1' => 'Pv A1',
            'pv_a2' => 'Pv A2',
            'pv_a3' => 'Pv A3',
            'pv_a4' => 'Pv A4',
            'pv_a5' => 'Pv A5',
            'pv_a6' => 'Pv A6',
            'pv_a7' => 'Pv A7',
            'pv_a8' => 'Pv A8',
            'output_p' => 'Output P',
            'temperatura' => 'Temperatura',
            'todayE' => 'Today E',
            'totalE' => 'Total E',
            'fp' => 'Fp',
            'inverter_m' => 'Inverter M',
            'inverter_f' => 'Inverter F',
        ];
    }

    /**
     * Gets query for [[Equipo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(SfvEquipos::className(), ['equipo_id' => 'equipo_id']);
    }

    /**
     * Gets query for [[InverterF]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInverterF()
    {
        return $this->hasOne(SfvInverterongridFail::className(), ['inverter_f_id' => 'inverter_f']);
    }

    /**
     * Gets query for [[InverterM]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInverterM()
    {
        return $this->hasOne(SfvInverterongridMode::className(), ['inverter_m_id' => 'inverter_m']);
    }
    
     
    public function validateDateread($attribute, $params) {
        
        $date = new \DateTime();
        
        $maxAgeDate = date_format($date, 'Y-m-d H:i:s');
        if ($this->$attribute > $maxAgeDate) {
            $this->addError($attribute, 'Date is to big.');
        }
    }
    
    
    public function validateTipoEquipo($attribute, $params){
        
        $_tipoequipo = SfvEquipos::find()->where(['equipo_id'=>$this->$attribute])->one();
        
        if($_tipoequipo->tipo_equipo_id != 13){
             $this->addError($attribute, 'Equipo no es ongrid');
        }
    }
}


