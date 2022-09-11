<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sge_circuitos".
 *
 * @property int $circuitos_id
 * @property string $alias
 * @property string $fecha_creado
 * @property string|null $fecha_modificador
 * @property int $estado_id 1->ACTIVO, 2->INACTIVO
 * @property int $proyecto_id
 * @property string|null $ip
 * @property float|null $valorkWh
 * @property int|null $estrato
 * @property int|null $maxactivadia
 * @property int|null $maxreactivadia
 * @property string|null $imagenasociada
 * @property string|null $nombre_sistema
 * @property int|null $concentrador_id
 * @property int|null $numerico
 *
 * @property SgeConcentradores $concentrador
 * @property SgeMedidores[] $sgeMedidores
 */
class SgeCircuitos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_circuitos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alias', 'fecha_creado', 'estado_id'], 'required'],
            [['estado_id',  'estrato', 'maxactivadia', 'maxreactivadia', 'concentrador_id', 'numerico'], 'default', 'value' => null],
            [['estado_id',  'estrato', 'maxactivadia', 'maxreactivadia', 'concentrador_id', 'numerico'], 'integer'],
            [['fecha_creado', 'fecha_modificador'], 'safe'],
            [['valorkWh'], 'number'],
            [['alias', 'imagenasociada', 'nombre_sistema'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 30],
            [['concentrador_id'], 'exist', 'skipOnError' => true, 'targetClass' => SgeConcentradores::className(), 'targetAttribute' => ['concentrador_id' => 'concentrador_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'circuitos_id' => 'Circuitos',
            'alias' => 'Alias',
            'fecha_creado' => 'Fecha Creado',
            'fecha_modificador' => 'Fecha Modificador',
            'estado_id' => 'Estado',
            'proyecto_id' => 'Proyecto',
            'ip' => 'Ip',
            'valorkWh' => 'Valork Wh',
            'estrato' => 'Estrato',
            'maxactivadia' => 'Maxactivadia',
            'maxreactivadia' => 'Maxreactivadia',
            'imagenasociada' => 'Imagenasociada',
            'nombre_sistema' => 'Nombre Sistema',
            'concentrador_id' => 'Concentrador',
            'numerico' => 'Numerico',
        ];
    }

    /**
     * Gets query for [[Concentrador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConcentrador()
    {
        return $this->hasOne(SgeConcentradores::className(), ['concentrador_id' => 'concentrador_id']);
    }
    /**
     * Gets query for [[SgeMedidores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSgeMedidores()
    {
        return $this->hasMany(SgeMedidores::className(), ['circuito_id' => 'circuitos_id']);
    }
}
