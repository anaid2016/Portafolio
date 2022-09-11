<?php

namespace app\models;namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_inverterongrid_mode".
 *
 * @property int $inverter_m_id
 * @property string|null $descripcion
 *
 * @property SfvLecturasOngrid[] $sfvLecturasOngrs
 */
class SfvInverterongridMode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_inverterongrid_mode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inverter_m_id'], 'required'],
            [['inverter_m_id'], 'default', 'value' => null],
            [['inverter_m_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 255],
            [['inverter_m_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'inverter_m_id' => 'Inverter M ID',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * Gets query for [[SfvLecturasOngrs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSfvLecturasOngrs()
    {
        return $this->hasMany(SfvLecturasOngrid::className(), ['inverter_m' => 'inverter_m_id']);
    }
}
