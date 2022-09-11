<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sge_proyectos".
 *
 * @property int $proyecto_id
 * @property string|null $nombre_proyecto
 * @property string|null $fecha_creado
 * @property string|null $fecha_modificado
 * @property int|null $usuario_id
 *
 * @property SgeCircuitos[] $sgeCircuitos
 * @property SgeUsuarios $usuario
 */
class SgeProyectos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_proyectos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_proyecto'], 'required'],
            [['proyecto_id', 'usuario_id'], 'default', 'value' => null],
            [['proyecto_id', 'usuario_id'], 'integer'],
            [['fecha_creado', 'fecha_modificado'], 'safe'],
            [['nombre_proyecto'], 'string', 'max' => 255],
            [['proyecto_id'], 'unique'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => SgeUsuarios::className(), 'targetAttribute' => ['usuario_id' => 'usuario_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'proyecto_id' => 'Proyecto',
            'nombre_proyecto' => 'Nombre Proyecto',
            'fecha_creado' => 'Fecha Creado',
            'fecha_modificado' => 'Fecha Modificado',
            'usuario_id' => 'Usuario',
        ];
    }

    /**
     * Gets query for [[SgeCircuitos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSgeCircuitos()
    {
        return $this->hasMany(SgeCircuitos::className(), ['proyecto_id' => 'proyecto_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(SgeUsuarios::className(), ['usuario_id' => 'usuario_id']);
    }
}
