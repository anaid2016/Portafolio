<?php

namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_tipo_equipos".
 *
 * @property int $tipo_equipo_id
 * @property string|null $nombre_tipo_equipo
 * @property string|null $marca
 *
 * @property SfvEquipos[] $sfvEquipos
 */
class SfvTipoEquipos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_tipo_equipos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo_equipo_id'], 'required'],
            [['tipo_equipo_id'], 'default', 'value' => null],
            [['tipo_equipo_id'], 'integer'],
            [['nombre_tipo_equipo', 'marca'], 'string', 'max' => 255],
            [['rutina_servicio'], 'string', 'max' => 1],
            [['tipo_equipo_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tipo_equipo_id' => 'Tipo Equipo ID',
            'nombre_tipo_equipo' => 'Nombre Tipo Equipo',
            'marca' => 'Marca',
            'rutina_servicio' => 'Rutina Servicio',
        ];
    }

    /**
     * Gets query for [[SfvEquipos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSfvEquipos()
    {
        return $this->hasMany(SfvEquipos::className(), ['tipo_equipo_id' => 'tipo_equipo_id']);
    }

    /**
     * Gets query for [[SfvTipoAlarmas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSfvTipoAlarmas()
    {
        return $this->hasMany(SfvTipoAlarma::className(), ['tipo_equipo_id' => 'tipo_equipo_id']);
    }
    
}    
