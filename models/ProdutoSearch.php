<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Produto;
use app\models\Insumos;
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

    public function searchInsumos($params)
    {

        $query = Insumos::find()->
        where(['idprodutoVenda'=>$params['produtovenda']] )->all();



        return $query;
    }

    public function searchProdutosCompra($idProduto)
    {

        $query = Compraproduto::find()->join(
            'INNER JOIN', 'compra', 'idCompra = idconta')->
        where(['idProduto'=>$idProduto] )->orderBy('dataCompra DESC')->one();



        return $query;
    }
}
