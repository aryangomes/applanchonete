<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tipocustofixo;

/**
 * TipocustofixoSearch represents the model behind the search form about `app\models\Tipocustofixo`.
 */
class TipocustofixoSearch extends Tipocustofixo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtipocustofixo'], 'integer'],
            [['tipocustofixo'], 'safe'],
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
        $query = Tipocustofixo::find();

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
            'idtipocustofixo' => $this->idtipocustofixo,
        ]);

        $query->andFilterWhere(['like', 'tipocustofixo', $this->tipocustofixo]);

        return $dataProvider;
    }
}
