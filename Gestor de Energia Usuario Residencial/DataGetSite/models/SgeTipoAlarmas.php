<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sge_tipo_alarmas".
 *
 * @property int $tipoalarma_id
 * @property string|null $nombre_tipo_alarma
 *
 * @property SgeAlarmas[] $sgeAlarmas
 */
class SgeTipoAlarmas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_tipo_alarmas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipoalarma_id'], 'required'],
            [['tipoalarma_id'], 'default', 'value' => null],
            [['tipoalarma_id'], 'integer'],
            [['nombre_tipo_alarma'], 'string', 'max' => 255],
            [['tipoalarma_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tipoalarma_id' => 'Tipoalarma ID',
            'nombre_tipo_alarma' => 'Nombre Tipo Alarma',
        ];
    }

    /**
     * Gets query for [[SgeAlarmas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSgeAlarmas()
    {
        return $this->hasMany(SgeAlarmas::className(), ['tipoalarma_id' => 'tipoalarma_id']);
    }
}
