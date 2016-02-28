<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Despesa;

/**
 * DespesaSearch represents the model behind the search form about `app\models\Despesa`.
 */
class DespesaSearch extends Despesa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iddespesa', 'situacaopagamento'], 'integer'],
            [['nomedespesa', 'datavencimento'], 'safe'],
            [['valordespesa'], 'number'],
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
        $query = Despesa::find();

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
            'iddespesa' => $this->iddespesa,
            'valordespesa' => $this->valordespesa,
            'situacaopagamento' => $this->situacaopagamento,
            'datavencimento' => $this->datavencimento,
        ]);

        $query->andFilterWhere(['like', 'nomedespesa', $this->nomedespesa]);

        return $dataProvider;
    }
}
