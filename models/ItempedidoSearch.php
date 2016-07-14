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
        and '" . $dataFinal . "' GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y')) 
         ORDER BY 'ip.idProduto, contasareceber.dataHora ASC'
        
        ")->queryAll();
        $qtdProdutosSum= [];
      
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

}
