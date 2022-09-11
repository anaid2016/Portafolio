<?php

namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_lecturas_contadores".
 *
 * @property int $registro_id
 * @property int|null $equipo_id Aqui solo aplica para equipos de medida como contadores
 * @property string|null $fecha_hora
 * @property int|null $modbusposition
 * @property float|null $tensionfaseA Tension en kV de la fase 
 * @property float|null $tensionfaseB Tension en kV de la fase
 * @property float|null $tensionfaseC Tension en kV de la fase
 * @property float|null $corrientefaseA Corriente en A de la fase
 * @property float|null $corrientefaseB Corriente en Amp de la fase
 * @property float|null $corrientefaseC corriente en Amp de la fase
 * @property float|null $activainsfaseA activa instantantea en kW
 * @property float|null $activainsfaseB activa instantantea en kW
 * @property float|null $activainsfaseC activa instantantea en kW
 * @property float|null $activainstotal activa instantanea total en kW
 * @property float|null $reactivainstotal reactiva instantanea total en kW
 * @property string|null $estado_encendido 0->Apagado, 1->Encendido, -1 Ni Idea
 * @property float|null $activa1 contador activa
 * @property float|null $reactiva1 contador reactiva
 * @property float|null $fpfaseA fp de la fase 
 * @property float|null $fpfaseB fp de la fase
 * @property float|null $fpfaseC fp de la fase
 * @property float|null $frecuencia frecuencia de la fase
 * @property string|null $fecha_insercion
 *
 * @property SfvEquipos $equipo
 */
class SfvLecturasContadores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_lecturas_contadores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipo_id','modbusposition','fecha_hora','tensionfaseA','tensionfaseB','tensionfaseC','corrientefaseA', 'corrientefaseB', 'corrientefaseC', 'activainsfaseA', 'activainsfaseB', 'activainsfaseC', 'activainstotal', 'reactivainstotal', 'activa1', 'reactiva1', 'fpfaseA', 'fpfaseB', 'fpfaseC', 'frecuencia'], 'required'],
            [['equipo_id', 'modbusposition'], 'integer'],
            [['fecha_hora'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['fecha_hora'], 'validateDateread'],
            [['fecha_insercion'], 'safe'],
            [['tensionfaseA', 'tensionfaseB', 'tensionfaseC', 'corrientefaseA', 'corrientefaseB', 'corrientefaseC', 'activainsfaseA', 'activainsfaseB', 'activainsfaseC', 'activainstotal', 'reactivainstotal', 'activa1', 'reactiva1', 'fpfaseA', 'fpfaseB', 'fpfaseC', 'frecuencia'], 'number'],
            [['estado_encendido'], 'string', 'max' => 1],
            [['tipo'], 'string', 'max' => 10],
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
            'modbusposition' => 'Modbusposition',
            'tensionfaseA' => 'Tensionfase A',
            'tensionfaseB' => 'Tensionfase B',
            'tensionfaseC' => 'Tensionfase C',
            'corrientefaseA' => 'Corrientefase A',
            'corrientefaseB' => 'Corrientefase B',
            'corrientefaseC' => 'Corrientefase C',
            'activainsfaseA' => 'Activainsfase A',
            'activainsfaseB' => 'Activainsfase B',
            'activainsfaseC' => 'Activainsfase C',
            'activainstotal' => 'Activainstotal',
            'reactivainstotal' => 'Reactivainstotal',
            'estado_encendido' => 'Estado Encendido',
            'activa1' => 'Activa1',
            'reactiva1' => 'Reactiva1',
            'fpfaseA' => 'Fpfase A',
            'fpfaseB' => 'Fpfase B',
            'fpfaseC' => 'Fpfase C',
            'frecuencia' => 'Frecuencia',
            'fecha_insercion' => 'Fecha Insercion',
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
    
    
    
    public function validateDateread($attribute, $params) {
        
        $date = new \DateTime();
        
        $maxAgeDate = date_format($date, 'Y-m-d H:i:s');
        if ($this->$attribute > $maxAgeDate) {
            $this->addError($attribute, 'Date is to big.');
        }
    }
    
    public function validateTipoEquipo($attribute, $params){
        
        $_tipoequipo = SfvEquipos::find()->where(['equipo_id'=>$this->$attribute])->one();
        
        if($_tipoequipo->tipo_equipo_id != 3){
             $this->addError($attribute, 'Equipo no es contador');
        }
    }
    
    
}
