<?php

namespace app\models\gisindicadores;

use Yii;
use app\models\modelpry\ModelPry;



/**
 * Esta es la clase del modelo para la tabla "indicador_parametro".
 *
  * @property int $cod_indi_param Identificador de la tabla indicador_parametro
 * @property string|null $nombre Nombre del parámetro o indicador
 * @property string|null $sigla Sigla del indicador o parámetro
 * @property string|null $descripcion Descripción del parámetro o indicador
 * @property string|null $formula Fórmula en formato TeX
 * @property string|null $tipo Tipo: indicador I, Parámetro P
 * @property int|null $cod_area Identificador de la tabla area_indica_param
 * @property string|null $unidad Unidad del parámetro o indicador
 * @property string|null $descr_relacion_param Descripción de la relación entre parámetros
 * @property string|null $estado Estado: A-activo, I- inactivo
 * @property string|null $fecha_desde Fecha desde que se encuentra activo el parámetro indicador
 * @property string|null $fecha_hasta Fecha hasta que se encuentra activo el parámetro indicador
 * @property string|null $tipo_dato Tipo de dato del indicador o parámetro: D-decimal, E-entero, P-porcentaje, A-Alfabético Alfanumérico 
 * @property int|null $relevancia_indicador Relevancia del indicador: 1- principal, 2- secundario
 * @property string|null $tipo_calc_parametro Tipo de cálculo del parametro: Anual, Promedio mensual, Total mensual, Promedio diario, 
 * @property float|null $valor_cumplimiento
 *
 * @property DesempenoIndiParam[] $desempenoIndiParams
 * @property Hechos[] $hechos
 * @property AreaIndicaParam $codArea
 * @property RelacionParamIndicador[] $relacionParamIndicadors
 * @property RelacionParamIndicador[] $relacionParamIndicadors0
 * @property IndicadorParametro[] $codParametros
 * @property IndicadorParametro[] $codIndicadors
 */
class IndicadorParametro extends ModelPry
{
	public $labelsgraf;
        public $valoresgraf;
        public $periodo;
	public $descript_formula;
	 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'indicador_parametro';
    }

    /**
     * {@inheritdoc} Reglas de Validación
     */
    public function rules()
    {
        return [
            [['cod_indi_param'], 'required'],
            [['cod_indi_param', 'cod_area', 'relevancia_indicador'], 'default', 'value' => null],
            [['fecha_desde', 'fecha_hasta'], 'safe'],
            [['valor_cumplimiento'], 'number'],
            [['nombre', 'formula'], 'string', 'max' => 250],
            [['sigla'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 500],
            [['tipo', 'estado', 'tipo_dato','calcular_valor_imprimir'], 'string', 'max' => 1],
            [['unidad'], 'string', 'max' => 30],
            [['descr_relacion_param'], 'string', 'max' => 800],
            [['tipo_calc_parametro','frecuencia_ingreso','tipo_calculo_indicador','frecuencia_x_calculo'], 'string', 'max' => 50],
            [['cod_indi_param'], 'unique'],
            [['cod_area'], 'exist', 'skipOnError' => true, 'targetClass' => AreaIndicaParam::className(), 'targetAttribute' => ['cod_area' => 'id_cod_area']],
        ];
    }

    /**
     * {@inheritdoc} Atributos para los labels del formulario CAMPO -> Label
     */
    public function attributeLabels()
    {
        return [
            'cod_indi_param' => 'Cod Indi Param',
            'nombre' => 'Nombre',
            'sigla' => 'Sigla',
            'descripcion' => 'Descripción',
            'formula' => 'Formula',
            'tipo' => 'Tipo',
            'cod_area' => 'Cod Area',
            'unidad' => 'Unidad',
            'descr_relacion_param' => 'Descr Relacion Param',
            'estado' => 'Estado',
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
            'tipo_dato' => 'Tipo Dato',
            'relevancia_indicador' => 'Relevancia Indicador',
            'tipo_calc_parametro' => 'Tipo Calc Parametro',
            'valor_cumplimiento' => 'Valor Cumplimiento',
        ];
    }

    /**
     * Realiza los query para [[DesempenoIndiParams]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getDesempenoIndiParams()
    {
        return $this->hasMany(DesempenoIndiParam::className(), ['cod_indi_param' => 'cod_indi_param']);
    }

    /**
     * Realiza los query para [[Hechos]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getHechos()
    {
        return $this->hasMany(Hechos::className(), ['cod_indi_param' => 'cod_indi_param']);
    }

    /**
     * Realiza los query para [[CodArea]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getCodArea()
    {
        return $this->hasOne(AreaIndicaParam::className(), ['id_cod_area' => 'cod_area']);
    }

    /**
     * Realiza los query para [[RelacionParamIndicadors]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getRelacionParamIndicadors()
    {
        return $this->hasMany(RelacionParamIndicador::className(), ['cod_indicador' => 'cod_indi_param']);
    }

    /**
     * Realiza los query para [[RelacionParamIndicadors0]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getRelacionParamIndicadors0()
    {
        return $this->hasMany(RelacionParamIndicador::className(), ['cod_parametro' => 'cod_indi_param']);
    }

    /**
     * Realiza los query para [[CodParametros]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getCodParametros()
    {
        return $this->hasMany(IndicadorParametro::className(), ['cod_indi_param' => 'cod_parametro'])->viaTable('relacion_param_indicador', ['cod_indicador' => 'cod_indi_param']);
    }

    /**
     * Realiza los query para [[CodIndicadors]].
     * @return \yii\db\ActiveQuery -> Relaciones que presenta la tabla
     */
    public function getCodIndicadors()
    {
        return $this->hasMany(IndicadorParametro::className(), ['cod_indi_param' => 'cod_indicador'])->viaTable('relacion_param_indicador', ['cod_parametro' => 'cod_indi_param']);
    }
    
    
    
    public function FormulaKatex()
    {
        
        $formula = $this->registerJs('katex.renderToString("c = \\pm\\sqrt{a^2 + b^2}", {
                        throwOnError: false
                    })');

        return $formula;
    }
}
