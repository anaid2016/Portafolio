<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SgeLecturas;
use kartik\daterange\DateRangeBehavior;
use Yii;

/**
 * SgeLecturasSearch represents the model behind the search form of `app\models\SgeLecturas`.
 */
class SgeLecturasSearch extends SgeLecturas
{
    public $createTimeStart;
    public $createTimeEnd;
    const DATE_FORMAT = 'Y-m-d';


    public $finicio;
    public $ffin;
    public $cto;
    public $alias;
    public $tgrafica;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'fecha_hora_registro',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
                'dateStartFormat' => self::DATE_FORMAT,
                'dateEndFormat' => self::DATE_FORMAT,
            ]
        ];
    }
    public function rules()
    {
        return [
            [['registro_lectura_id', 'medidor_id', 'alias'], 'integer'],
            [['fecha_hora_registro', 'estado_rele', 'fecha_hora_ingreso'], 'safe'],
            [['tensionfaseA', 'tensionfaseB', 'tensionfaseC', 'corrientefaseA', 'corrientefaseB', 'corrientefaseC', 'activainsfaseA', 'activainsfaseB', 'activainsfaseC', 'activainstotal', 'reactivainstotal', 'energia_activa', 'energia_reactiva', 'fpfaseA', 'fpfaseB', 'fpfaseC', 'frecuencia'], 'number'],
            [['fecha_hora_registro'], 'safe'],
            [['fecha_hora_registro'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        
        $query = SgeLecturas::find()
            ->leftJoin('sge_medidores', 'sge_medidores.medidor_id = sge_lecturas.medidor_id')
            ->leftJoin('sge_circuitos', 'sge_circuitos.circuitos_id = sge_medidores.circuito_id')
            ->leftJoin('sge_concentradores', 'sge_concentradores.concentrador_id = sge_circuitos.concentrador_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        
//        if(!empty(Yii::$app->user->id)){
//            
//            $id = Yii::$app->user->id;
//            $identity = Yii::$app->user->identity;
//            $perfil = $identity->perfil_id;
//            
//            //Buscando circuitos asociados =====================================================================
//            $sql = SgeMedidores::find()
//                   ->leftJoin('sge_circuitos', 'sge_medidores.circuito_id =sge_circuitos.circuitos_id')
//                   ->leftJoin('sge_proyectos', 'sge_proyectos.proyecto_id =sge_circuitos.proyecto_id')
//                   ->leftJoin('sge_usuarios', 'sge_usuarios.usuario_id =sge_proyectos.usuario_id')
//                   ->where(['sge_usuarios.usuario_id'=>$id]) 
//                   ->all();
//            
//            if(empty($sql) && $perfil == '2'){
//                $query->where('0=1');
//                return $dataProvider;
//            }
//            
//            $vmedidores = array();
//            foreach($sql as $medidor){
//                $vmedidores[]=$medidor->medidor_id;
//            }
//        }
//        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'registro_lectura_id' => $this->registro_lectura_id,
            // 'fecha_hora_registro' => $this->fecha_hora_registro,
            'medidor_id' => $this->medidor_id,
            'tensionfaseA' => $this->tensionfaseA,
            'tensionfaseB' => $this->tensionfaseB,
            'tensionfaseC' => $this->tensionfaseC,
            'corrientefaseA' => $this->corrientefaseA,
            'corrientefaseB' => $this->corrientefaseB,
            'corrientefaseC' => $this->corrientefaseC,
            'activainsfaseA' => $this->activainsfaseA,
            'activainsfaseB' => $this->activainsfaseB,
            'activainsfaseC' => $this->activainsfaseC,
            'activainstotal' => $this->activainstotal,
            'reactivainstotal' => $this->reactivainstotal,
            'energia_activa' => $this->energia_activa,
            'energia_reactiva' => $this->energia_reactiva,
            'fpfaseA' => $this->fpfaseA,
            'fpfaseB' => $this->fpfaseB,
            'fpfaseC' => $this->fpfaseC,
            'frecuencia' => $this->frecuencia,
            'fecha_hora_ingreso' => $this->fecha_hora_ingreso,
            'sge_concentradores.concentrador_id' => $this->alias,
        ]);


        if (!empty($this->fecha_hora_registro) and strlen($this->fecha_hora_registro) > 12) {
            $fechas = explode(' - ', $this->fecha_hora_registro);
            $query->andFilterWhere(['between', 'fecha_hora_registro', $fechas[0], $fechas[1]]);
        }

        if(!empty($vmedidores)){
             $query->andFilterWhere(['sge_lecturas.medidor_id'=>$vmedidores]);
        }

        return $dataProvider;
    }




    public function searchg()
    {
        if (empty($this->cto) || empty($this->ffin)) {
            return false;
        }

        if ($this->tgrafica == 1) {

            $sql = "SELECT * FROM sge_lecturas sl "
                . "left join sge_medidores sm on sm.medidor_id=sl.medidor_id "
                . "left join sge_circuitos sc on sc.circuitos_id=sm.circuito_id "
                . "WHERE circuito_id = " . $this->cto . " and fecha_hora_registro>='" . $this->finicio . " 00:00:00' and fecha_hora_registro<='" . $this->ffin . " 00:00:00'";
        } else {

            $sql = "SELECT DATE
            ( fecha_hora_registro ),
            extract(hour from fecha_hora_registro),
            MAX ( energia_activa ) as max_activa,
            MIN ( energia_activa ) as min_activa,
            MAX ( energia_reactiva) as max_reactiva,
            MIN ( energia_reactiva) as min_reactiva
            FROM
            sge_lecturas 
            LEFT JOIN sge_medidores ON sge_medidores.medidor_id = sge_lecturas.medidor_id
            LEFT JOIN sge_circuitos ON sge_circuitos.circuitos_id = sge_medidores.circuito_id 
            WHERE
            sge_circuitos.circuitos_id = " . $this->cto . "
            AND fecha_hora_registro >= '" . $this->finicio . " 00:00:00' 
            AND fecha_hora_registro <= '" . $this->ffin . " 00:00:00' 
            GROUP BY
            date(fecha_hora_registro), extract(hour from fecha_hora_registro)
             ORDER BY date(fecha_hora_registro), extract(hour from fecha_hora_registro) 
            ";
        }
        $sql = Yii::$app->db->createCommand($sql)->queryAll();

        return $sql;
    }
}
