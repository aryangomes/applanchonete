<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Produto;
use app\models\Insumo;

/**
 * ProdutoSearch represents the model behind the search form about `app\models\Produto`.
 */
class ProdutoSearch extends Produto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProduto', 'isInsumo', 'idCategoria'], 'integer'],
            [['nome'], 'safe'],
            [['valorVenda', 'quantidadeMinima', 'quantidadeEstoque'], 'number'],
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
        $query = Produto::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'=> ['defaultOrder' => ['idProduto'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'idProduto' => $this->idProduto,
            'valorVenda' => $this->valorVenda,
            'isInsumo' => $this->isInsumo,
            'quantidadeMinima' => $this->quantidadeMinima,
            'idCategoria' => $this->idCategoria,
            'quantidadeEstoque' => $this->quantidadeEstoque,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome]);

        return $dataProvider;
    }

    public function searchInsumos($id)
    {

        $query = Insumo::find()->joinWith('produtoInsumo')->
        where(['idprodutoVenda' => $id])->all();


        return $query;
    }

    public function searchProdutosVenda($params)
    {

        $query = Insumo::find()->
        where(['idprodutoInsumo' => $params['idinsumo']])->all();


        return $query;
    }

    public function searchInsumosProdutosVenda($idProdutoVenda)
    {

        $query = Insumo::find()->joinWith('idprodutoInsumo')->
        where(['idprodutoVenda' => $idProdutoVenda])->all();


        return $query;
    }


    public function searchProdutosVendaIndex($params)
    {
        $query = Produto::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('insumos')
            ->where(['isInsumo' => 0])->all();


        return $dataProvider;
    }

    public function searchProdutosCompra($idProduto)
    {

        $query = Compraproduto::find()->join(
            'INNER JOIN', 'compra', 'idCompra = idconta')->
        where(['idProduto' => $idProduto])->orderBy('dataCompra DESC')->one();


        return $query;
    }

    /**
     * @param $idProdutoVenda
     * @return mixed
     */
    public function searchQuantidadeProdutosEmVendas($idProdutoVenda)
    {
          //Guarda o mês anterior
        $mes = (date('m')-1);


        //Guarda o último dia do mês
        $lastDayOfMonth = date('t', strtotime(date('Y') . '-' . $mes . '-' . date('d')));


        //Busca os produtos vendidos(produzidos) no período mensal(Do primeiro até o último dia do mês atual)
        $query =
            Produto::find()
                ->joinWith('itempedidos')
                ->joinWith('itempedidos.pedido')
                ->joinWith('itempedidos.pedido.pagamento')
                ->joinWith('itempedidos.pedido.pagamento.contasareceber')
                ->joinWith('itempedidos.pedido.pagamento.contasareceber.conta')
                ->where(['produto.idProduto' => $idProdutoVenda])
                ->andWhere(['between', 'dataHora',
                    date('Y') . '-' . $mes . '-' . '01', date('Y') . '-' . $mes . '-' . $lastDayOfMonth]);

        //Guarda a soma dos produtos vendidos(produzidos) no período mensal(Do primeiro até o último dia do mês)
        $sumQuantidade = $query->sum('quantidade');

        return $sumQuantidade;
    }
}
