<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Itempedido;

/**
 * ItempedidoSearch represents the model behind the search form about `app\models\Itempedido`.
 */
class ItempedidoSearch extends Itempedido {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['idPedido', 'idProduto'], 'integer'],
            [['quantidade', 'total'], 'number'],
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
        $query = Itempedido::find();

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
            'idPedido' => $this->idPedido,
            'idProduto' => $this->idProduto,
            'quantidade' => $this->quantidade,
            'total' => $this->total,
        ]);

        return $dataProvider;
    }

    public function searchItensPedido($dataInicio, $dataFinal) {

        $query = \Yii::$app->db->createCommand("
        SELECT *, SUM(ip.quantidade) FROM produto prod NATURAL JOIN (itempedido ip NATURAL JOIN (pedido ped NATURAL JOIN 
        (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta))) 
        JOIN conta on conta.idconta = contasareceber.idconta 
        WHERE contasareceber.dataHora BETWEEN '" . $dataInicio . "'
        and '" . $dataFinal . "' GROUP BY ip.idProduto 
         ORDER BY ' contasareceber.dataHora ASC'
        
        ")->queryAll();
        $qtdProdutosSum = [];

        foreach ($query as $itemped) {

            $auxCountPedidos = [
                'name' => ($itemped ["nome"]),
                'data' => [intval($itemped["SUM(ip.quantidade)"])],
            ];
//            var_dump([intval($ped["SUM(ip.quantidade)"])]);
//              var_dump(\Yii::$app->db->createCommand(""
//                    . "SELECT *,SUM(ip.quantidade) FROM itempedido ip JOIN "
//                      . "pedido p on p.idPedido = ip.idPedido GROUP BY ip.idProduto")
//                      ->queryAll());

            array_push($qtdProdutosSum, $auxCountPedidos);
        }

        return $qtdProdutosSum;
    }

    public function searchLucro($dataInicio, $dataFinal) {

        /* $query = \Yii::$app->db->createCommand("
          SELECT *, SUM(ip.total) FROM produto prod NATURAL JOIN (itempedido ip NATURAL JOIN (pedido ped NATURAL JOIN
          (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta)))
          JOIN conta on conta.idconta = contasareceber.idconta
          WHERE contasareceber.dataHora BETWEEN '" . $dataInicio . "'
          and '" . $dataFinal . "' GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y'))
          ORDER BY ' contasareceber.dataHora ASC'

          ")->queryAll();
          $lucroProduto = [];

          foreach ($query as $itemped) {
          $faturamentoProduto = floatval($itemped["SUM(ip.total)"]);
          $custoProduto = intval($itemped["quantidade"]) *
          floatval(Produto::findOne($itemped["idProduto"])
          ->calculoPrecoProduto($itemped["idProduto"]));


          $diferenca = $faturamentoProduto - $custoProduto;
          $auxLucro = [
          'name' => date('d/m/Y', strtotime($itemped["dataHora"])),
          'data' => [floatval(number_format(($diferenca), 2))],
          ];


          array_push($lucroProduto, $auxLucro);
          } */
        $totalPedidosVendas = $this->getTotalPedidoVendas($dataInicio, $dataFinal);
        $custosProdutos = $this->getCustosProdutos($dataInicio, $dataFinal);
        $datas = $this->getDatasParaCalculoDeLucro($dataInicio, $dataFinal);
        $lucroProduto = [];

        if (count($datas) > 0 &&
                count($totalPedidosVendas) > 0 &&
                count($custosProdutos) > 0 &&
                count($totalPedidosVendas) == count($custosProdutos)) {
            foreach ($datas as $key => $item) {

                $diferenca = $totalPedidosVendas[$key] - $custosProdutos[$key];
                $auxLucro = [
                    'name' => date('d/m/Y', strtotime($item)),
                    'data' => [floatval(number_format(($diferenca), 2))],
                ];
                array_push($lucroProduto, $auxLucro);
            }
        }

        return $lucroProduto;
    }

    public function getTotalPedidoVendas($dataInicio, $dataFinal) {

        $query = \Yii::$app->db->createCommand("
        SELECT *, SUM(ip.total) FROM produto prod NATURAL JOIN (itempedido ip NATURAL JOIN (pedido ped NATURAL JOIN 
        (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta))) 
        JOIN conta on conta.idconta = contasareceber.idconta 
        WHERE contasareceber.dataHora BETWEEN '" . $dataInicio . "'
        and '" . $dataFinal . "' GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y'))
         ORDER BY ' contasareceber.dataHora ASC'
        
        ")->queryAll();
        $faturamentos = [];

        foreach ($query as $q) {
            $faturamento = floatval($q["SUM(ip.total)"]);



            array_push($faturamentos, $faturamento);
        }

        return $faturamentos;
    }

    public function getDatasParaCalculoDeLucro($dataInicio, $dataFinal) {

        $query = \Yii::$app->db->createCommand("
        SELECT * FROM produto prod NATURAL JOIN (itempedido ip NATURAL JOIN (pedido ped NATURAL JOIN 
        (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta))) 
        JOIN conta on conta.idconta = contasareceber.idconta 
        WHERE contasareceber.dataHora BETWEEN '" . $dataInicio . "'
        and '" . $dataFinal . "' GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y'))
         ORDER BY ' contasareceber.dataHora ASC'
        
        ")->queryAll();




        $datasVendas = [];
        foreach ($query as $q) {
            $dataVenda = date("Y-m-d", strtotime($q["dataHora"]));
            array_push($datasVendas, $dataVenda);
        }
        return $datasVendas;
    }

    public function getCustosProdutos($dataInicio, $dataFinal) {

        $query = \Yii::$app->db->createCommand("
        SELECT * FROM produto prod NATURAL JOIN (itempedido ip NATURAL JOIN (pedido ped NATURAL JOIN 
        (pagamento p JOIN contasareceber ON p.idConta = contasareceber.idconta))) 
        JOIN conta on conta.idconta = contasareceber.idconta 
        WHERE contasareceber.dataHora BETWEEN '" . $dataInicio . "'
        and '" . $dataFinal . "' GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y'))
         ORDER BY ' contasareceber.dataHora ASC'
        
        ")->queryAll();



        $custosProdutos = [];
        $datasVendas = $this->getDatasParaCalculoDeLucro($dataInicio, $dataFinal);


        if(count($datasVendas)> 0) {
            foreach ($datasVendas as $key => $dv) {

                $pedidosDoDia = [];
                $pedido = Pedido::find()
                                ->joinWith('pagamento')
                                ->joinWith('pagamento.contasareceber')
                                ->where(['between', 'dataHora', $dv . ' 00:00', $dv . ' 23:59'])->all();
                array_push($pedidosDoDia, $pedido);


                $itensPedido = [];

                foreach ($pedidosDoDia as $key => $pedido) {
                    for ($i = 0; $i < count($pedido); $i++) {

                        $itemPedido = Itempedido::find()->where(['idPedido' => $pedido[$i]->idPedido])->all();
                        array_push($itensPedido, $itemPedido);
                    }
                }


                $valorCustoTotal = 0;

                foreach ($itensPedido as $key => $ip) {

                    for ($i = 0; $i < count($ip); $i++) {
                        $valorCustoTotal += (intval($ip[$i]->quantidade) *
                                floatval(number_format(Produto::findOne($ip[$i]->idProduto)->calculoPrecoProduto
                                                        ($ip[$i]->idProduto), 2)));
                    }
                }


                array_push($custosProdutos, $valorCustoTotal);
            }
        }
        return $custosProdutos;
    }

}
