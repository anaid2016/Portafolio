<?php

namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_modulo".
 *
 * @property int $modulo_id
 * @property string|null $nombre_modulo
 *
 * @property SfvTrazabilidad[] $sfvTrazabilidads
 */
class SfvModulo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_modulo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modulo_id'], 'required'],
            [['modulo_id'], 'default', 'value' => null],
            [['modulo_id'], 'integer'],
            [['nombre_modulo'], 'string', 'max' => 255],
            [['modulo_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'modulo_id' => 'Modulo ID',
            'nombre_modulo' => 'Nombre Modulo',
        ];
    }

    /**
     * Gets query for [[SfvTrazabilidads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSfvTrazabilidads()
    {
        return $this->hasMany(SfvTrazabilidad::className(), ['modulo_id' => 'modulo_id']);
    }
}
