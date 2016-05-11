<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Compraproduto;

/**
 * CompraprodutoSearch represents the model behind the search form about `app\models\Compraproduto`.
 */
class CompraprodutoSearch extends Compraproduto
{

     public $produto;
     public $conta;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCompra', 'idProduto'], 'integer'],
            [['quantidade', 'valorCompra'], 'number'],
            [['produto','conta'], 'safe'],
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
        $query = Compraproduto::find();

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
            'idCompra' => $this->idCompra,
            'idProduto' => $this->idProduto,
            'quantidade' => $this->quantidade,
            'valorCompra' => $this->valorCompra,
        ]);

        return $dataProvider;
    }
}
