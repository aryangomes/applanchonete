<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Caixa;

/**
 * CaixaSearch represents the model behind the search form about `app\models\Caixa`.
 */
class CaixaSearch extends Caixa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['idcaixa', 'user_id'], 'integer'],
        [['valorapurado', 'valoremcaixa', 'valorlucro'], 'number'],
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
        $query = Caixa::find();

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
            'idcaixa' => $this->idcaixa,
            'valorapurado' => $this->valorapurado,
            'valoremcaixa' => $this->valoremcaixa,
            'valorlucro' => $this->valorlucro,
            'user_id' => Yii::$app->user->getId(),
            ]);

        return $dataProvider;
    }
}
