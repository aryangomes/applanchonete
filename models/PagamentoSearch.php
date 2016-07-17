<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pagamento;

/**
 * PagamentoSearch represents the model behind the search form about `app\models\Pagamento`.
 */
class PagamentoSearch extends Pagamento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTipoPagamento', 'idConta', 'idPedido'], 'integer'],
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
        $query = Pagamento::find();

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
            'idTipoPagamento' => $this->idTipoPagamento,
            'idConta' => $this->idConta,
            'idPedido' => $this->idPedido,
        ]);

        return $dataProvider;
    }

    public function searchDatasPagamentosContasAReceberPorPeriodo($dataInicio,$dataFinal)
    {
      /*  $query = Pagamento::find()
            ->joinWith('contasareceber')
            ->joinWith('contasareceber.conta')
            ->where(['between','dataHora',$dataInicio,$dataFinal])
            ->orderBy('dataHora ASC')->all();*/

        $query = [];

        $formasPagamentos = Formapagamento::find()->all();
        foreach ($formasPagamentos as $fp) {
            $auxQuery = \Yii::$app->db->createCommand("
        SELECT *, COUNT('idTipoPagamento') FROM (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta) 
        JOIN conta on conta.idconta = contasareceber.idconta WHERE contasareceber.dataHora BETWEEN '".$dataInicio."'
        and '".$dataFinal."' and idTipoPagamento ="
                .$fp->idTipoPagamento." GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y')) 
                 ORDER BY 'idTipoPagamento, contasareceber.dataHora ASC'
        
        ")->queryAll();

            array_push($query , $auxQuery);
        }



        $datasPagamentos = [];

//        var_dump($query);
      for ($i=0;$i< count($query);$i++) {
          for ($j = 0; $j < count($query[$i]); $j++) {
              array_push($datasPagamentos, date("d/m/Y", strtotime($query[$i][$j]["dataHora"])));
          }
      }

        return $datasPagamentos;
    }

    public function searchCountPagamentosContasAReceberPorPeriodo($dataInicio,$dataFinal)
    {

        $query = [];

        $formasPagamentos = Formapagamento::find()->all();
        foreach ($formasPagamentos as $fp) {
            $auxQuery = \Yii::$app->db->createCommand("
        SELECT *, COUNT('idTipoPagamento') FROM (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta) 
        JOIN conta on conta.idconta = contasareceber.idconta WHERE contasareceber.dataHora BETWEEN '".$dataInicio."'
        and '".$dataFinal."' and idTipoPagamento ="
                .$fp->idTipoPagamento." GROUP BY (idTipoPagamento)  ORDER BY 'idTipoPagamento, contasareceber.dataHora ASC'
        
        ")->queryAll();

            array_push($query , $auxQuery);
        }

        $countTiposPagamentos = [];


        for ($i=0;$i< count($query);$i++) {
            for ($j = 0; $j < count($query[$i]); $j++) {
                array_push($countTiposPagamentos, intval($query[$i][$j]["COUNT('idTipoPagamento')"]));
            }
        }

        return $countTiposPagamentos;
    }

    public function searchPagamentosContasAReceberPorPeriodo($dataInicio,$dataFinal)
    {
        $query = [];
        $tiposPagamentos = [];
        $auxTiposPagamentos = [];
        $auxCountTiposPagamentos = [];
        $formasPagamentos = Formapagamento::find()->all();
        $countTiposPagamentos = $this->searchCountPagamentosContasAReceberPorPeriodo($dataInicio, $dataFinal);
        
       
        foreach ($formasPagamentos as $key => $fp) {
            $auxQuery = \Yii::$app->db->createCommand("
        SELECT *, COUNT('idTipoPagamento') FROM (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta) 
        JOIN conta on conta.idconta = contasareceber.idconta WHERE contasareceber.dataHora BETWEEN '".$dataInicio."'
        and '".$dataFinal."' and idTipoPagamento ="
                .$fp->idTipoPagamento." GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y'))  ORDER BY 'idTipoPagamento, contasareceber.dataHora ASC'
        
        ")->queryAll();

            foreach($auxQuery as $aq){
               array_push($auxCountTiposPagamentos,($aq["COUNT('idTipoPagamento')"]));
            }

            $auxTiposPagamentos = [
                'name'=> $fp->titulo,
                'data'=> [ intval($countTiposPagamentos[$key])],
            ];
            $auxCountTiposPagamentos =[];
            array_push($tiposPagamentos , $auxTiposPagamentos);

        }

       

        return $tiposPagamentos;
    }
}
