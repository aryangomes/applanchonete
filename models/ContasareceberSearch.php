<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Contasareceber;

/**
 * ContasareceberSearch represents the model behind the search form about `app\models\Contasareceber`.
 */
class ContasareceberSearch extends Contasareceber {

    public $conta;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['idconta'], 'integer'],
            [['dataHora', 'conta'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Contasareceber::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
              'pagination' => [
                'pageSize' => 10,
            ],
               'sort'=> ['defaultOrder' => ['idconta'=>SORT_DESC]],
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

    public function searchDatasContasAReceberPorPeriodo($dataInicio, $dataFinal) {
        /* $query = \Yii::$app->db->createCommand("
          SELECT *, SUM(valor) from contasareceber cb JOIN conta c on c.idconta = cb.idconta WHERE
          dataHora BETWEEN '".$dataInicio."' and '".$dataFinal."'
          GROUP BY (DATE_FORMAT(dataHora,'%m-%d-%Y'))
          ")->queryAll(); */
        $query = \Yii::$app->db->createCommand("
       SELECT *, SUM(valor) FROM produto prod NATURAL JOIN (itempedido ip NATURAL JOIN (pedido ped NATURAL JOIN 
        (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta))) 
        JOIN conta on conta.idconta = contasareceber.idconta 
        WHERE contasareceber.dataHora BETWEEN '" . $dataInicio . "'
        and '" . $dataFinal . "' GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y'))
         ORDER BY ' contasareceber.dataHora ASC'
        ")->queryAll();
        $datasContasAReceber = [];

        foreach ($query as $ctareceber) {
            array_push($datasContasAReceber, date('d/m/Y', strtotime($ctareceber ["dataHora"])));
        }


        return $datasContasAReceber;
    }

    public function searchContasAReceberPorPeriodo($dataInicio, $dataFinal) {
        /* $query = \Yii::$app->db->createCommand("
          SELECT *, SUM(valor) from contasareceber cb JOIN conta c on c.idconta = cb.idconta WHERE
          dataHora BETWEEN '".$dataInicio."' and '".$dataFinal."'
          GROUP BY (DATE_FORMAT(dataHora,'%m-%d-%Y'))
          ")->queryAll(); */

        $query = \Yii::$app->db->createCommand("
       SELECT *, SUM(total) FROM produto prod NATURAL JOIN (itempedido ip NATURAL JOIN (pedido ped NATURAL JOIN 
        (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta))) 
        JOIN conta on conta.idconta = contasareceber.idconta 
        WHERE contasareceber.dataHora BETWEEN '" . $dataInicio . "'
        and '" . $dataFinal . "' GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y'))
         ORDER BY ' contasareceber.dataHora ASC'
        ")->queryAll();

        $valoresContasAReceber = [];
        $aux = [];
//        foreach ($query as $ctareceber){
//            array_push($valoresContasAReceber,$ctareceber['SUM(valor)']);
//        }

        foreach ($query as $ctareceber) {


            $aux = [
                'name' => date('d/m/Y', strtotime($ctareceber ["dataHora"])),
                'data' => [floatval(number_format ($ctareceber["SUM(total)"],2))],
            ];

            array_push($valoresContasAReceber, $aux);
        }


        return $valoresContasAReceber;
    }

}
