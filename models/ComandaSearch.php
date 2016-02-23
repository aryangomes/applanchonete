<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comanda;

/**
 * ComandaSearch represents the model behind the search form about `app\models\Comanda`.
 */
class ComandaSearch extends Comanda
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idComanda', 'status', 'mesaIdMesa'], 'integer'],
            [['desconto', 'totalPago', 'totalPedidos'], 'number'],
            [['dataHoraAbertura', 'dataHoraFechamento', 'descricao'], 'safe'],
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
        $query = Comanda::find();

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
            'idComanda' => $this->idComanda,
            'desconto' => $this->desconto,
            'totalPago' => $this->totalPago,
            'dataHoraAbertura' => $this->dataHoraAbertura,
            'dataHoraFechamento' => $this->dataHoraFechamento,
            'status' => $this->status,
            'totalPedidos' => $this->totalPedidos,
            'mesaIdMesa' => $this->mesaIdMesa,
        ]);

        $query->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
}
