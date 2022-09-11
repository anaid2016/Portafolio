<?php

namespace app\models\gisindicadores;

use Yii;

/**
 * This is the model class for table "demarcacion".
 *
 * @property int $cod_demarcacion
 * @property string|null $nombre
 * @property string|null $sigla
 * @property string|null $codigo
 * @property string|null $estado
 * @property string|null $fecha_desde
 * @property string|null $fecha_hasta
 *
 * @property Localizacion[] $localizacions
 */
class Demarcacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'demarcacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cod_demarcacion'], 'required'],
            [['cod_demarcacion'], 'default', 'value' => null],
            [['cod_demarcacion'], 'integer'],
            [['fecha_desde', 'fecha_hasta'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
            [['sigla', 'codigo'], 'string', 'max' => 10],
            [['estado'], 'string', 'max' => 1],
            [['cod_demarcacion'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cod_demarcacion' => 'Cod Demarcacion',
            'nombre' => 'Nombre',
            'sigla' => 'Sigla',
            'codigo' => 'Codigo',
            'estado' => 'Estado',
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
        ];
    }

    /**
     * Gets query for [[Localizacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacions()
    {
        return $this->hasMany(Localizacion::className(), ['cod_demarcacion' => 'cod_demarcacion']);
    }
}
