<?php

namespace app\models\gisindicadores;

use Yii;
use app\models\modelpry\ModelPry;

/**
 * Esta es la clase del modelo para la tabla "glosario".
 *
  * @property int $cod_glosario
 * @property string|null $nombre
 * @property string|null $descripcion
 */
class Glosario extends ModelPry
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'glosario';
    }

    /**
     * {@inheritdoc} Reglas de Validación
     */
    public function rules()
    {
        return [
            [['cod_glosario'], 'required'],
            [['cod_glosario'], 'integer'],
            [['nombre', 'descripcion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc} Atributos para los labels del formulario CAMPO -> Label
     */
    public function attributeLabels()
    {
        return [
            'cod_glosario' => 'Cod Glosario',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }
}
