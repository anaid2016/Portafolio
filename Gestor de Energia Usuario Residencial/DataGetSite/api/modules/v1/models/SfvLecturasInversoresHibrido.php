<?php

namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_lecturas_inversores".
 *
 * @property int $registro_id
 * @property int|null $equipo_id
 * @property string|null $fecha_hora
 * @property float|null $grid
 * @property float|null $byp
 * @property float|null $out
 * @property float|null $outp
 * @property float|null $outs
 * @property float|null $outload
 * @property float|null $outpf
 * @property float|null $temp
 * @property float|null $ongp
 * @property float|null $ongkwh
 * @property float|null $batv
 * @property float|null $batporcentaje
 * @property float|null $pvv
 * @property float|null $pvp
 * @property float|null $kwhdia
 * @property float|null $kwhtotal
 * @property string|null $pvstatus
 * @property string|null $runstatus
 * @property string|null $sysmode
 * @property string|null $batstatus
 * @property string|null $genstatus
 * @property string|null $gridstatus
 *
 * @property SfvEquipos $equipo
 */
class SfvLecturasInversoresHibrido extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_lecturas_hibrido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipo_id','fecha_hora','grid', 'byp', 'out', 'outp', 'outs', 'outload', 'outpf', 'temp', 'ongp', 'ongkwh', 'batv', 'batporcentaje', 'pvv', 'pvp', 'kwhdia', 'kwhtotal','pvstatus', 'runstatus', 'batstatus', 'genstatus', 'gridstatus','sysmode'], 'required'],
            [['equipo_id','modbusposition'], 'integer'],
            [['fecha_hora'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['fecha_hora'], 'validateDateread'],
            [['grid', 'byp', 'out', 'outp', 'outs', 'outload', 'outpf', 'temp', 'ongp', 'ongkwh', 'batv', 'batporcentaje', 'pvv', 'pvp', 'kwhdia', 'kwhtotal'], 'number'],
            [['pvstatus', 'runstatus', 'batstatus', 'genstatus', 'gridstatus'], 'string', 'max' => 2],
            [['sysmode'], 'string', 'max' => 25],
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
            'grid' => 'Grid',
            'byp' => 'Byp',
            'out' => 'Out',
            'outp' => 'Outp',
            'outs' => 'Outs',
            'outload' => 'Outload',
            'outpf' => 'Outpf',
            'temp' => 'Temp',
            'ongp' => 'Ongp',
            'ongkwh' => 'Ongkwh',
            'batv' => 'Batv',
            'batporcentaje' => 'Batporcentaje',
            'pvv' => 'Pvv',
            'pvp' => 'Pvp',
            'kwhdia' => 'Kwhdia',
            'kwhtotal' => 'Kwhtotal',
            'pvstatus' => 'Pvstatus',
            'runstatus' => 'Runstatus',
            'sysmode' => 'Sysmode',
            'batstatus' => 'Batstatus',
            'genstatus' => 'Genstatus',
            'gridstatus' => 'Gridstatus',
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
        
        if($_tipoequipo->tipo_equipo_id != 1){
             $this->addError($attribute, 'Equipo no es hibrido');
        }
    }
}
