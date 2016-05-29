<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Insumo;
use app\models\Produto;

/**
 * InsumosSearch represents the model behind the search form about `app\models\Insumos`.
 */
class InsumoSearch extends Insumo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['idprodutoVenda', 'idprodutoInsumo'], 'integer'],
        [['quantidade'], 'number'],
        [['unidade'], 'safe'],
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
        $query = Insumo::find();

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
            'idprodutoVenda' => $this->idprodutoVenda,
            'idprodutoInsumo' => $this->idprodutoInsumo,
            'quantidade' => $this->quantidade,
            ]);

        $query->andFilterWhere(['like', 'unidade', $this->unidade]);

        return $dataProvider;
    }

    public function searchInsumos($params)
    {

        $query = Insumo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            ]);

        $query->joinWith('produtoInsumo');

        $query->andFilterWhere([
            'isInsumo' => 1,

            ]);
        
        return $dataProvider;
    }
}
