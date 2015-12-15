<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Compra;

/**
 * CompraSearch represents the model behind the search form about `app\models\Compra`.
 */
class CompraSearch extends Compra
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datacompra'], 'safe'],
            [['totalcompra'], 'number'],
            [['idcompra', 'fornecedor_idFornecedor'], 'integer'],
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
        $query = Compra::find();

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
            'datacompra' => $this->datacompra,
            'totalcompra' => $this->totalcompra,
            'idcompra' => $this->idcompra,
            'fornecedor_idFornecedor' => $this->fornecedor_idFornecedor,
        ]);

        return $dataProvider;
    }
}
