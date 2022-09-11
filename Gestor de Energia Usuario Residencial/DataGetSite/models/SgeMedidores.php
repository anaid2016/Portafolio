<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sge_medidores".
 *
 * @property int $medidor_id
 * @property int $circuito_id
 * @property int|null $estado_id 1->ACTIVO, 2-> INACTIVO
 * @property float|null $modbusposition
 * @property string|null $serial
 * @property string|null $fecha_creado
 * @property string|null $fecha_modificado
 *
 * @property SgeCircuitos $circuito
 * @property SgeLecturas[] $sgeLecturas
 */
class SgeMedidores extends \yii\db\ActiveRecord
{
    public $proyecto_id;
    public $usuario;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_medidores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['circuito_id','proyecto_id','modbusposition','serial'], 'required'],
            [['estado_id'], 'default', 'value' => null],
            [['circuito_id', 'estado_id','tipo_medidor_id','corriente_1','corriente_2','corriente_3'], 'integer'],
            [['modbusposition'], 'number'],
            [['fecha_creado', 'fecha_modificado','proyecto_id'], 'safe'],
            [['serial'], 'string', 'max' => 20],
            [['medidor_id'], 'unique'],
            [['circuito_id'], 'exist', 'skipOnError' => true, 'targetClass' => SgeCircuitos::className(), 'targetAttribute' => ['circuito_id' => 'circuitos_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'medidor_id' => 'Medidor ID',
            'circuito_id' => 'Circuito',
            'estado_id' => 'Estado ID',
            'modbusposition' => 'Modbusposition',
            'serial' => 'Serial',
            'fecha_creado' => 'Fecha Creado',
            'fecha_modificado' => 'Fecha Modificado',
            'proyecto_id' => 'Concentrador',
            'corriente_1' => 'Corriente 1',
            'corriente_2' => 'Corriente 2',
            'corriente_3' => 'Corriente 3',
        ];
    }

    /**
     * Gets query for [[Circuito]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCircuito()
    {
        return $this->hasOne(SgeCircuitos::className(), ['circuitos_id' => 'circuito_id']);
    }

    /**
     * Gets query for [[SgeLecturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSgeLecturas()
    {
        return $this->hasMany(SgeLecturas::className(), ['medidor_id' => 'medidor_id']);
    }
    
    
    
    public function sgeproyecto($medidor_id){
        

        $sql = 'SELECT sge_proyectos.* FROM sge_proyectos
                LEFT JOIN sge_concentradores ON sge_concentradores.proyecto_id = sge_proyectos.proyecto_id
                LEFT JOIN sge_circuitos ON sge_circuitos.concentrador_id = sge_concentradores.concentrador_id
                LEFT JOIN sge_medidores ON sge_medidores.circuito_id = sge_circuitos.circuitos_id
                WHERE sge_medidores.medidor_id=:medidorid';
        
       $connection=Yii::$app->db;
       $command=$connection->createCommand();
       $command->sql=$sql;
       $command->bindParam(':medidorid',$medidor_id, \PDO::PARAM_INT);
       $resultado = $command->queryAll();
       
        foreach($resultado as $register){
            return $register['nombre_proyecto'];
        }
        
    }
    
    
    public function getSgeSure(){
       return $this->hasOne(SgeSureusuarios::className(), ['medidor_id' => 'medidor_id']); 
    }
}
