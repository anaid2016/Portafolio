<?php

namespace app\models\gisindicadores;

use Yii;

/**
 * This is the model class for table "tipo_localizacion".
 *
 * @property int $id_tipolocalizacion
 * @property string|null $nombre_tipolocalizacion
 *
 * @property Localizacion[] $localizacions
 */
class TipoLocalizacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_localizacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipolocalizacion'], 'required'],
            [['id_tipolocalizacion'], 'default', 'value' => null],
            [['id_tipolocalizacion'], 'integer'],
            [['nombre_tipolocalizacion'], 'string', 'max' => 50],
            [['id_tipolocalizacion'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipolocalizacion' => 'Id Tipolocalizacion',
            'nombre_tipolocalizacion' => 'Nombre Tipolocalizacion',
        ];
    }

    /**
     * Gets query for [[Localizacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacions()
    {
        return $this->hasMany(Localizacion::className(), ['id_tipolocalizacion' => 'id_tipolocalizacion']);
    }
}
