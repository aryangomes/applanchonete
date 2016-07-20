<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contasareceber;

/**
 * ContasareceberSearch represents the model behind the search form about `app\models\Contasareceber`.
 */
class ContasareceberSearch extends Contasareceber
{

    public $conta;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['idconta'], 'integer'],
        [['dataHora','conta'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Contasareceber::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idconta' => $this->idconta,
            'dataHora' => $this->dataHora,
            ]);

        return $dataProvider;
    }

    public function searchDatasContasAReceberPorPeriodo($dataInicio,$dataFinal)
    {
        $sql = "SELECT * from contasareceber cb JOIN conta c on c.idconta = cb.idconta WHERE dataHora BETWEEN '2000-01-01' and '2020-01-01' GROUP BY (DATE_FORMAT(dataHora,'%m-%d-%Y'))";   
        $query = \Yii::$app->db->createCommand("
       SELECT *, SUM(valor) from contasareceber cb JOIN conta c on c.idconta = cb.idconta WHERE 
       dataHora BETWEEN '".$dataInicio."' and '".$dataFinal."' 
        GROUP BY (DATE_FORMAT(dataHora,'%m-%d-%Y'))      
        ")->queryAll();

        $datasContasAReceber = [];
       
        foreach ($query as $ctareceber){
            array_push($datasContasAReceber,date('d/m/Y',strtotime($ctareceber ["dataHora"])));
        }

       
        return $datasContasAReceber;
    }

    public function searchContasAReceberPorPeriodo($dataInicio,$dataFinal)
    {
         $sql = "SELECT * from contasareceber cb JOIN conta c on c.idconta = cb.idconta WHERE dataHora BETWEEN '2000-01-01' and '2020-01-01' GROUP BY (DATE_FORMAT(dataHora,'%m-%d-%Y'))";   
        $query = \Yii::$app->db->createCommand("
       SELECT *, SUM(valor) from contasareceber cb JOIN conta c on c.idconta = cb.idconta WHERE 
       dataHora BETWEEN '".$dataInicio."' and '".$dataFinal."' 
        GROUP BY (DATE_FORMAT(dataHora,'%m-%d-%Y'))      
        ")->queryAll();
     


        $valoresContasAReceber = [];
       $aux = [];
//        foreach ($query as $ctareceber){
//            array_push($valoresContasAReceber,$ctareceber['SUM(valor)']);
//        }
        
        foreach ($query as $ctareceber){
         

            $aux = [
                'name'=>date('d/m/Y',strtotime($ctareceber ["dataHora"])),
                'data'=>[floatval($ctareceber["SUM(valor)"])],
            ];

            array_push($valoresContasAReceber,$aux);
        }


        return $valoresContasAReceber;
    }
}
