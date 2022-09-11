<?php

namespace app\models\gisindicadores;

use Yii;

/**
 * This is the model class for table "localizacion".
 *
 * @property int $cod_localizacion
 * @property string|null $cod_oficial
 * @property string|null $nombre
 * @property int|null $id_tipolocalizacion
 * @property int|null $id_localizacionpadre
 * @property int|null $cod_demarcacion
 * @property string|null $ubicacionjson
 * @property int|null $censo
 * @property string|null $estado
 * @property string|null $fecha_desde
 * @property string|null $fecha_hasta
 * @property string|null $latcenter Latitud localizacion
 * @property string|null $longcenter Longitud localizacion
 * @property string|null $nombre_cabecera nombre cabecera cantonal
 *
 * @property Hechos[] $hechos
 * @property Demarcacion $codDemarcacion
 * @property Localizacion $localizacionpadre
 * @property Localizacion[] $localizacions
 * @property TipoLocalizacion $tipolocalizacion
 * @property LocalizacionPrestador[] $localizacionPrestadors
 * @property Prestador[] $codPrestadors
 */
class Localizacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'localizacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cod_localizacion'], 'required'],
            [['cod_localizacion', 'id_tipolocalizacion', 'id_localizacionpadre', 'cod_demarcacion', 'censo'], 'default', 'value' => null],
            [['cod_localizacion', 'id_tipolocalizacion', 'id_localizacionpadre', 'cod_demarcacion', 'censo'], 'integer'],
            [['fecha_desde', 'fecha_hasta'], 'safe'],
            [['cod_oficial'], 'string', 'max' => 10],
            [['nombre'], 'string', 'max' => 50],
            [['ubicacionjson'], 'string', 'max' => 8000],
            [['estado'], 'string', 'max' => 1],
            [['latcenter', 'longcenter'], 'string', 'max' => 11],
            [['nombre_cabecera'], 'string', 'max' => 80],
            [['cod_localizacion'], 'unique'],
            [['cod_demarcacion'], 'exist', 'skipOnError' => true, 'targetClass' => Demarcacion::className(), 'targetAttribute' => ['cod_demarcacion' => 'cod_demarcacion']],
            [['id_localizacionpadre'], 'exist', 'skipOnError' => true, 'targetClass' => Localizacion::className(), 'targetAttribute' => ['id_localizacionpadre' => 'cod_localizacion']],
            [['id_tipolocalizacion'], 'exist', 'skipOnError' => true, 'targetClass' => TipoLocalizacion::className(), 'targetAttribute' => ['id_tipolocalizacion' => 'id_tipolocalizacion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cod_localizacion' => 'Cod Localizacion',
            'cod_oficial' => 'Cod Oficial',
            'nombre' => 'Nombre',
            'id_tipolocalizacion' => 'Id Tipolocalizacion',
            'id_localizacionpadre' => 'Id Localizacionpadre',
            'cod_demarcacion' => 'Cod Demarcacion',
            'ubicacionjson' => 'Ubicacionjson',
            'censo' => 'Censo',
            'estado' => 'Estado',
            'fecha_desde' => 'Fecha Desde',
            'fecha_hasta' => 'Fecha Hasta',
            'latcenter' => 'Latcenter',
            'longcenter' => 'Longcenter',
            'nombre_cabecera' => 'Nombre Cabecera',
        ];
    }

    /**
     * Gets query for [[Hechos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHechos()
    {
        return $this->hasMany(Hechos::className(), ['cod_localizacion' => 'cod_localizacion']);
    }

    /**
     * Gets query for [[CodDemarcacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodDemarcacion()
    {
        return $this->hasOne(Demarcacion::className(), ['cod_demarcacion' => 'cod_demarcacion']);
    }

    /**
     * Gets query for [[Localizacionpadre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacionpadre()
    {
        return $this->hasOne(Localizacion::className(), ['cod_localizacion' => 'id_localizacionpadre']);
    }

    /**
     * Gets query for [[Localizacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacions()
    {
        return $this->hasMany(Localizacion::className(), ['id_localizacionpadre' => 'cod_localizacion']);
    }

    /**
     * Gets query for [[Tipolocalizacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipolocalizacion()
    {
        return $this->hasOne(TipoLocalizacion::className(), ['id_tipolocalizacion' => 'id_tipolocalizacion']);
    }

    /**
     * Gets query for [[LocalizacionPrestadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacionPrestadors()
    {
        return $this->hasMany(LocalizacionPrestador::className(), ['cod_localizacion' => 'cod_localizacion']);
    }

    /**
     * Gets query for [[CodPrestadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodPrestadors()
    {
        return $this->hasMany(Prestador::className(), ['cod_prestador' => 'cod_prestador'])->viaTable('localizacion_prestador', ['cod_localizacion' => 'cod_localizacion']);
    }
    
    

    public function getTotalPrestador(){
        return $this->hasMany(LocalizacionPrestador::className(), ['cod_localizacion' => 'cod_localizacion'])->count();
    } 
    
}
