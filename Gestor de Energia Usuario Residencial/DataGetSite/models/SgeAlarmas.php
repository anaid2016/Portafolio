<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sge_alarmas".
 *
 * @property int $alarma_id
 * @property int|null $modbusposition
 * @property int|null $circuito_id
 * @property string|null $descripcion
 * @property float|null $valor1
 * @property float|null $valor2
 * @property float|null $valor3
 * @property int|null $tipoalarma_id
 *
 * @property SgeTipoAlarmas $tipoalarma
 */
class SgeAlarmas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sge_alarmas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['modbusposition', 'circuito_id', 'tipoalarma_id'], 'default', 'value' => null],
            [['modbusposition', 'circuito_id', 'tipoalarma_id'], 'integer'],
            [['valor1', 'valor2', 'valor3'], 'number'],
            [['descripcion'], 'string', 'max' => 255],
            [['tipoalarma_id'], 'exist', 'skipOnError' => true, 'targetClass' => SgeTipoAlarmas::className(), 'targetAttribute' => ['tipoalarma_id' => 'tipoalarma_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'alarma_id' => 'Alarma ID',
            'modbusposition' => 'Modbusposition',
            'circuito_id' => 'Circuito ID',
            'descripcion' => 'Descripcion',
            'valor1' => 'Valor 1',
            'valor2' => 'Valor 2',
            'valor3' => 'Valor 3',
            'tipoalarma_id' => 'Tipoalarma ID',
        ];
    }

    /**
     * Gets query for [[Tipoalarma]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoalarma()
    {
        return $this->hasOne(SgeTipoAlarmas::className(), ['tipoalarma_id' => 'tipoalarma_id']);
    }
}
