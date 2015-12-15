<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Fornecedor;

/**
 * FornecedorSearch represents the model behind the search form about `app\models\Fornecedor`.
 */
class FornecedorSearch extends Fornecedor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cnpj', 'nome', 'endereco'], 'safe'],
            [['idFornecedor'], 'integer'],
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
        $query = Fornecedor::find();

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
            'idFornecedor' => $this->idFornecedor,
        ]);

        $query->andFilterWhere(['like', 'cnpj', $this->cnpj])
            ->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'endereco', $this->endereco]);

        return $dataProvider;
    }
}
