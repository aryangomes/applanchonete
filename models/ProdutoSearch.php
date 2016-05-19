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

        $query = Insumo::find()->
        where(['idprodutoVenda'=>$id] )->all();



        return $query;
    }

    public function searchProdutosVenda($params)
    {

        $query = Insumo::find()->
        where(['idprodutoInsumo'=>$params['idinsumo']] )->all();



        return $query;
    }

    public function searchInsumosProdutosVenda($idProdutoVenda)
    {

        $query = Insumo::find()->
        where(['idprodutoVenda'=>$idProdutoVenda] )->all();



        return $query;
    }


    public function searchProdutosVendaIndex($params)
    {
      $query = Produto::find();

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
        ]);
      $query->joinWith('insumos')
      ->where(['isInsumo'=>0])->all();



      return $dataProvider;
  }
  public function searchProdutosCompra($idProduto)
  {

    $query = Compraproduto::find()->join(
        'INNER JOIN', 'compra', 'idCompra = idconta')->
    where(['idProduto'=>$idProduto] )->orderBy('dataCompra DESC')->one();



    return $query;
}
}
