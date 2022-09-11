<?php

namespace app\models\gisindicadores;

use Yii;
use app\models\modelpry\ModelPry;

/**
 * Esta es la clase del modelo para la tabla "clasificacion_categorias".
 *
  * @property int $id_clasificacion_categoria
 * @property string|null $nom_categoria
 * @property int|null $eficiencia_servicio_sup
 * @property int|null $total_gadm
 * @property string|null $nom_calificacion
 * @property string|null $estado 'A'->ACTIVO, 'I'->INACTIVO
 * @property int|null $eficiencia_servicio_inf
 *
 * @property EvaluacionLocalizacionPrestador[] $evaluacionLocalizacionPrestadors
 */
class ClasificacionCategorias extends ModelPry
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clasificacion_categorias';
    }

    /**
     * {@inheritdoc} Reglas de Validación
     */
    public function rules()
    {
        return [
            [['id_clasificacion_categoria'], 'required'],
            [['id_clasificacion_categoria', 'eficiencia_servicio_sup', 'total_gadm', 'eficiencia_servicio_inf'], 'integer'],
            [['nom_categoria'], 'string', 'max' => 2],
            [['nom_calificacion'], 'string', 'max' => 255],
            [['estado'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc} Atributos para los labels del formulario CAMPO -> Label
     */
    public function attributeLabels()
    {
        return [
            'id_clasificacion_categoria' => 'Id Clasificacion Categoria',
            'nom_categoria' => 'Nom Categoria',
            'eficiencia_servicio_sup' => 'Eficiencia Servicio Sup',
            'total_gadm' => 'Total Gadm',
            'nom_calificacion' => 'Nom Calificacion',
            'estado' => 'Estado',
            'eficiencia_servicio_inf' => 'Eficiencia Servicio Inf',
        ];
    }

    /**
     * Realiza los query para [[EvaluacionLocalizacionPrestadors]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getEvaluacionLocalizacionPrestadors()
    {
        return $this->hasMany(EvaluacionLocalizacionPrestador::className(), ['id_clasificacion_categoria' => 'id_clasificacion_categoria']);
    }
}
