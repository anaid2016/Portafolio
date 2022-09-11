<?php

namespace app\models\gisindicadores;

use Yii;
use app\models\modelpry\ModelPry;

/**
 * Esta es la clase del modelo para la tabla "evaluacion_localizacion_prestador".
 *
  * @property int $id_evaluacion
 * @property int|null $id_localizacion_prestador
 * @property float|null $valor
 * @property int|null $anio
 * @property int|null $id_clasificacion_categoria
 *
 * @property ClasificacionCategorias $idClasificacionCategoria
 * @property LocalizacionPrestador $idLocalizacionPrestador
 */
class EvaluacionLocalizacionPrestador extends ModelPry
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluacion_localizacion_prestador';
    }

    /**
     * {@inheritdoc} Reglas de Validación
     */
    public function rules()
    {
        return [
            [['id_evaluacion'], 'required'],
            [['id_evaluacion', 'id_localizacion_prestador', 'anio', 'id_clasificacion_categoria'], 'integer'],
            [['valor'], 'number'],
            [['id_clasificacion_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => ClasificacionCategorias::className(), 'targetAttribute' => ['id_clasificacion_categoria' => 'id_clasificacion_categoria']],
            [['id_localizacion_prestador'], 'exist', 'skipOnError' => true, 'targetClass' => LocalizacionPrestador::className(), 'targetAttribute' => ['id_localizacion_prestador' => 'id_localizacion_prestador']],
        ];
    }

    /**
     * {@inheritdoc} Atributos para los labels del formulario CAMPO -> Label
     */
    public function attributeLabels()
    {
        return [
            'id_evaluacion' => 'Id Evaluacion',
            'id_localizacion_prestador' => 'Id Localizacion Prestador',
            'valor' => 'Valor',
            'anio' => 'Anio',
            'id_clasificacion_categoria' => 'Id Clasificacion Categoria',
        ];
    }

    /**
     * Realiza los query para [[IdClasificacionCategoria]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getIdClasificacionCategoria()
    {
        return $this->hasOne(ClasificacionCategorias::className(), ['id_clasificacion_categoria' => 'id_clasificacion_categoria']);
    }

    /**
     * Realiza los query para [[IdLocalizacionPrestador]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getIdLocalizacionPrestador()
    {
        return $this->hasOne(LocalizacionPrestador::className(), ['id_localizacion_prestador' => 'id_localizacion_prestador']);
    }
}
