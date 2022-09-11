<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sge_concentradores".
 *
 * @property int $concentrador_id
 * @property string|null $alias_concentrador
 * @property string|null $serial_concentrador
 * @property int|null $proyecto_id
 * @property string|null $ip
 *
 * @property SgeProyectos $proyecto
 * @property SgeCircuitos[] $sgeCircuitos
 */
class SgeConcentradores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_concentradores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proyecto_id'], 'required'],
            [['proyecto_id'], 'integer'],
            [['alias_concentrador', 'serial_concentrador', 'ip'], 'string', 'max' => 255],
            [['proyecto_id'], 'exist', 'skipOnError' => true, 'targetClass' => SgeProyectos::className(), 'targetAttribute' => ['proyecto_id' => 'proyecto_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'concentrador_id' => 'Concentrador',
            'alias_concentrador' => 'Alias Concentrador',
            'serial_concentrador' => 'Serial Concentrador',
            'proyecto_id' => 'Proyecto',
            'ip' => 'Ip',
        ];
    }

    /**
     * Gets query for [[Proyecto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProyecto()
    {
        return $this->hasOne(SgeProyectos::className(), ['proyecto_id' => 'proyecto_id']);
    }

    /**
     * Gets query for [[SgeCircuitos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSgeCircuitos()
    {
        return $this->hasMany(SgeCircuitos::className(), ['concentrador_id' => 'concentrador_id']);
    }
}
