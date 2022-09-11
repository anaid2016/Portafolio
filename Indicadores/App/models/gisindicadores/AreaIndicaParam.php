<?php

namespace app\models\gisindicadores;

use Yii;
use app\models\modelpry\ModelPry;

/**
 * Esta es la clase del modelo para la tabla "area_indica_param".
 *
  * @property int $id_cod_area Identificador de la tabla area_indica_param
 * @property string|null $sigla Sigla del área del indicador o parámetro
 * @property string|null $nombre_area Nombre del área
 *
 * @property IndicadorParametro[] $indicadorParametros
 */
class AreaIndicaParam extends ModelPry
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'area_indica_param';
    }

    /**
     * {@inheritdoc} Reglas de Validación
     */
    public function rules()
    {
        return [
            [['id_cod_area'], 'required'],
            [['id_cod_area'], 'integer'],
            [['sigla'], 'string', 'max' => 4],
            [['nombre_area'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc} Atributos para los labels del formulario CAMPO -> Label
     */
    public function attributeLabels()
    {
        return [
            'id_cod_area' => 'Id Cod Area',
            'sigla' => 'Sigla',
            'nombre_area' => 'Nombre Area',
        ];
    }

    /**
     * Realiza los query para [[IndicadorParametros]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getIndicadorParametros()
    {
        return $this->hasMany(IndicadorParametro::className(), ['cod_area' => 'id_cod_area']);
    }
}
