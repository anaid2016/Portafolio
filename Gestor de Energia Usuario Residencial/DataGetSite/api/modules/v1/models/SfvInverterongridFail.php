<?php

namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_inverterongrid_fail".
 *
 * @property int $inverter_f_id
 * @property string|null $descripcion
 *
 * @property SfvLecturasOngrid[] $sfvLecturasOngrs
 */
class SfvInverterongridFail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_inverterongrid_fail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inverter_f_id'], 'required'],
            [['inverter_f_id'], 'default', 'value' => null],
            [['inverter_f_id'], 'integer'],
            [['descripcion'], 'string', 'max' => 255],
            [['inverter_f_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'inverter_f_id' => 'Inverter F ID',
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
        return $this->hasMany(SfvLecturasOngrid::className(), ['inverter_f' => 'inverter_f_id']);
    }
}
