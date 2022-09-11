<?php

namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_trazabilidad".
 *
 * @property int $trazabilidad_id
 * @property int|null $tipo_evento_id
 * @property int|null $modulo_id
 * @property string|null $observacion
 * @property string|null $fecha_evento
 * @property string|null $fecha_ingreso
 * @property int|null $usuario_id
 *
 * @property SfvModulo $modulo
 * @property SfvTipoeventoTrazabilidad $tipoEvento
 */
class SfvTrazabilidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_trazabilidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_evento_id', 'modulo_id', 'usuario_id'], 'required'],
            [['tipo_evento_id', 'modulo_id', 'usuario_id','proyecto_id','equipo_id'], 'integer'],
            [['fecha_evento', 'fecha_ingreso'], 'safe'],
            [['observacion'], 'string', 'max' => 255],
            [['extra'],'string','max'=>10],
            [['modulo_id'], 'exist', 'skipOnError' => true, 'targetClass' => SfvModulo::className(), 'targetAttribute' => ['modulo_id' => 'modulo_id']],
            [['tipo_evento_id'], 'exist', 'skipOnError' => true, 'targetClass' => SfvTipoeventoTrazabilidad::className(), 'targetAttribute' => ['tipo_evento_id' => 'tipoevento_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'trazabilidad_id' => 'Trazabilidad ID',
            'tipo_evento_id' => 'Tipo Evento ID',
            'modulo_id' => 'Modulo ID',
            'observacion' => 'Observacion',
            'fecha_evento' => 'Fecha Evento',
            'fecha_ingreso' => 'Fecha Ingreso',
            'usuario_id' => 'Usuario ID',
            'extra'=>'Extra'
        ];
    }

    /**
     * Gets query for [[Modulo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModulo()
    {
        return $this->hasOne(SfvModulo::className(), ['modulo_id' => 'modulo_id']);
    }

    /**
     * Gets query for [[TipoEvento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoEvento()
    {
        return $this->hasOne(SfvTipoeventoTrazabilidad::className(), ['tipoevento_id' => 'tipo_evento_id']);
    }
}
