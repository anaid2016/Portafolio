<?php

namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_lecturas_controlador".
 *
 * @property int $registro_id
 * @property int|null $equipo_id
 * @property string|null $fecha_hora
 * @property float|null $batp
 * @property float|null $batv
 * @property float|null $batch
 * @property float|null $loadv
 * @property float|null $loada
 * @property float|null $loadp
 * @property float|null $pvv
 * @property float|null $pvp
 * @property float|null $maxdispd
 * @property float|null $totbod
 * @property float|null $totbfc
 * @property float|null $powgen
 * @property string|null $loadstatus
 * @property string|null $faultwarning
 *
 * @property SfvEquipos $equipo
 */
class SfvLecturasControlador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_lecturas_controlador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipo_id','batp', 'batv', 'batch', 'loadv', 'loada', 'loadp', 'pvv', 'pvp', 'maxdispd', 'totbod', 'totbfc', 'powgen','fecha_hora'],'required'],
            [['equipo_id','modbusposition'], 'integer'],
            [['fecha_hora'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['fecha_hora'], 'validateDateread'],
            [['batp', 'batv', 'batch', 'loadv', 'loada', 'loadp', 'pvv', 'pvp', 'maxdispd', 'totbod', 'totbfc', 'powgen'], 'number'],
            [['loadstatus', 'faultwarning'], 'string', 'max' => 5],
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
            'batp' => 'Batp',
            'batv' => 'Batv',
            'batch' => 'Batch',
            'loadv' => 'Loadv',
            'loada' => 'Loada',
            'loadp' => 'Loadp',
            'pvv' => 'Pvv',
            'pvp' => 'Pvp',
            'maxdispd' => 'Maxdispd',
            'totbod' => 'Totbod',
            'totbfc' => 'Totbfc',
            'powgen' => 'Powgen',
            'loadstatus' => 'Loadstatus',
            'faultwarning' => 'Faultwarning',
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
        
        if($_tipoequipo->tipo_equipo_id != 2){
             $this->addError($attribute, 'Equipo no es controlador');
        }
    }
}
