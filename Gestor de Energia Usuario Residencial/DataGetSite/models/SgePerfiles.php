<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sge_perfiles".
 *
 * @property int $perfil_id
 * @property string|null $nombre_perfil
 *
 * @property SgeUsuarios[] $sgeUsuarios
 */
class SgePerfiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_perfiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_perfil'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'perfil_id' => 'Perfil ID',
            'nombre_perfil' => 'Nombre Perfil',
        ];
    }

    /**
     * Gets query for [[SgeUsuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSgeUsuarios()
    {
        return $this->hasMany(SgeUsuarios::className(), ['perfil_id' => 'perfil_id']);
    }
}
