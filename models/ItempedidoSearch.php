<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Itempedido;

/**
 * ItempedidoSearch represents the model behind the search form about `app\models\Itempedido`.
 */
class ItempedidoSearch extends Itempedido
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPedido', 'idProduto'], 'integer'],
            [['quantidade', 'total'], 'number'],
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

    public function searchItensPedido($dataInicio, $dataFinal)
    {

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


            array_push($qtdProdutosSum, $auxCountPedidos);
        }

        return $qtdProdutosSum;
    }

    //Retorna os lucros dos Pedidos Concluídos por data, de acordo com o intervalo passado
    public function searchLucro($dataInicio, $dataFinal)
    {
        //Guarda os pedidos concluídos
        $pedidosConcluidos = Pedido::find()
            ->joinWith('pagamento')
            ->joinWith('pagamento.contasareceber')
            ->where(

                ['between', 'dataHora', $dataInicio, $dataFinal]
            )
            ->where(['idSituacaoAtual' => 2])->all();

        //Guarda os valores de lucro total dos pedidos concluidos diarios
        $valoresLucroTotal = [];

        //Modelo de Caixa usado para utilizar o metodo calculaValorLucroPedido($idPedido)
        $caixa = new Caixa();

        //Guarda as datas que tiveram os pedidos concluidos de acordo com o intervalo informado
        $datasPedidosConcluidos = ($this->getDatasParaCalculoDeLucro($dataInicio, $dataFinal));

        foreach ($datasPedidosConcluidos as $dataPedConc) {

            $auxValorLucro = 0;

            foreach ($pedidosConcluidos as $pedConc) {

                //Guarda a data do Pedido Concluido
                $dataPedidoConcluido = date('Y-m-d', strtotime($pedConc['pagamento']['contasareceber']->dataHora));

                if ($dataPedidoConcluido == $dataPedConc) {
                    $auxValorLucro += floatval(number_format(($caixa->calculaValorLucroPedido($pedConc->idPedido))
                        , 2));

                }

            }

            //Guarda o valor do lucro no array tendo como chave a data do dia desse lucro
            $auxLucro = [
                'name' => date('d/m/Y', strtotime($dataPedConc)),
                'data' => [$auxValorLucro],
            ];

            //Adiciona o valor total do lucro de um dia ao array
            array_push($valoresLucroTotal, $auxLucro);

        }
        return $valoresLucroTotal;

    }


    public function getDatasParaCalculoDeLucro($dataInicio, $dataFinal)
    {
        //Guarda as datas dos Pedidos Concluidos
        $datasPedidosConcluidos = [];

        $pedidosConcluidos = Pedido::find()
            ->joinWith('pagamento')
            ->joinWith('pagamento.contasareceber')
            ->where(

                ['between', 'dataHora', $dataInicio, $dataFinal]
            )
            ->andFilterWhere(['idSituacaoAtual' => 2])
            ->all();

        foreach ($pedidosConcluidos as $pedConc) {
            //Guarda a data do pedido
            $data = date('Y-m-d', strtotime($pedConc['pagamento']['contasareceber']->dataHora));

            if (!in_array($data, $datasPedidosConcluidos)) {

                array_push($datasPedidosConcluidos, $data);

            }

        }

        return $datasPedidosConcluidos;
    }


}
