<?php

namespace app\models;

use app\models\Pedido;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PedidoSearch represents the model behind the search form about `app\models\Pedido`.
 */
class PedidoSearch extends Pedido
{

   public $situacaopedido;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['idPedido', 'idSituacaoAtual'], 'integer'],
        [['situacaopedido'] , 'safe'],
        [['totalPedido'], 'number'],
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
        $query = Pedido::find();

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
            'totalPedido' => $this->totalPedido,
            'idSituacaoAtual' => $this->idSituacaoAtual,
            ]);

        return $dataProvider;
    }

    public function searchCountPedidosContasAReceberPorPeriodo($dataInicio,$dataFinal)
    {


        $query = \Yii::$app->db->createCommand("
        SELECT *, COUNT('idPedido') FROM pedido ped JOIN (pagamento p JOIN contasareceber 
        ON p.idConta = contasareceber.idconta) on ped.idPedido = p.idPedido JOIN conta 
        ON conta.idconta = contasareceber.idconta WHERE contasareceber.dataHora BETWEEN '".$dataInicio."'
        and '".$dataFinal."' GROUP BY (DATE_FORMAT(contasareceber.dataHora,'%m-%d-%Y')) 
         ORDER BY 'contasareceber.dataHora ASC'
        
        ")->queryAll();
        $pedidosCount = [];
        $pedidosDatas = [];
        foreach ($query as $ped){
            array_push($pedidosDatas,date('d/m/Y',strtotime($ped ["dataHora"])));

            $auxCountPedidos = [
                'name'=>date('d/m/Y',strtotime($ped ["dataHora"])),
                'data'=>[intval($ped["COUNT('idPedido')"])],
            ];

            array_push($pedidosCount,$auxCountPedidos);
        }

        return [$pedidosCount,$pedidosDatas];
    }

    
    
    public function searchItensPedidoViewPedido($idPedido) {
        $query = Pedido::find()
                   ->joinWith('itempedidos')
                ->joinWith('itempedidos.produto')
                ->where([
            'pedido.idPedido' => $idPedido,
           
        ])->all();

        // add conditions that should always apply here

       

        return $query;
    }
}
