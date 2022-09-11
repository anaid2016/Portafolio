<?php

namespace app\models\gisindicadores;

use Yii;

/**
 * This is the model class for table "log_carga".
 *
 * @property int $consecutivocarga
 * @property string|null $origen
 * @property string|null $fecha
 * @property string|null $hora
 * @property int|null $registroscargados
 *
 * @property Hechos[] $hechos
 */
class LogCarga extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_carga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['consecutivocarga'], 'required'],
            [['consecutivocarga', 'registroscargados'], 'default', 'value' => null],
            [['consecutivocarga', 'registroscargados'], 'integer'],
            [['fecha', 'hora'], 'safe'],
            [['origen'], 'string', 'max' => 100],
            [['consecutivocarga'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'consecutivocarga' => 'Consecutivocarga',
            'origen' => 'Origen',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'registroscargados' => 'Registroscargados',
        ];
    }

    /**
     * Gets query for [[Hechos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHechos()
    {
        return $this->hasMany(Hechos::className(), ['consecutivocarga' => 'consecutivocarga']);
    }
}
