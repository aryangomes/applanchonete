<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pagamento;

/**
 * PagamentoSearch represents the model behind the search form about `app\models\Pagamento`.
 */
class PagamentoSearch extends Pagamento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPagamento', 'tipoPagamento_idTipoPagamento', 'idComanda'], 'integer'],
            [['valor'], 'number'],
            [['dataHora', 'descricao'], 'safe'],
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
        $query = Pagamento::find();

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
            'idPagamento' => $this->idPagamento,
            'valor' => $this->valor,
            'dataHora' => $this->dataHora,
            'tipoPagamento_idTipoPagamento' => $this->tipoPagamento_idTipoPagamento,
            'idComanda' => $this->idComanda,
        ]);

        $query->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
}
