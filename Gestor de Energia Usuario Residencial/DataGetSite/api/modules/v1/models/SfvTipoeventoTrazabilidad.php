<?php

namespace app\api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "sfv_tipoevento_trazabilidad".
 *
 * @property int $tipoevento_id
 * @property string|null $nombre_tipoevento
 *
 * @property SfvTrazabilidad[] $sfvTrazabilidads
 */
class SfvTipoeventoTrazabilidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sfv_tipoevento_trazabilidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipoevento_id'], 'required'],
            [['tipoevento_id'], 'default', 'value' => null],
            [['tipoevento_id'], 'integer'],
            [['nombre_tipoevento'], 'string', 'max' => 255],
            [['tipoevento_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tipoevento_id' => 'Tipoevento ID',
            'nombre_tipoevento' => 'Nombre Tipoevento',
        ];
    }

    /**
     * Gets query for [[SfvTrazabilidads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSfvTrazabilidads()
    {
        return $this->hasMany(SfvTrazabilidad::className(), ['tipo_evento_id' => 'tipoevento_id']);
    }
}
