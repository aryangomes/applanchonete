<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Relatorio;

/**
 * RelatorioSearch represents the model behind the search form about `app\models\Relatorio`.
 */
class RelatorioSearch extends Relatorio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idrelatorio', 'usuario_id'], 'integer'],
            [['nome', 'datageracao', 'tipo', 'inicio_intervalo', 'fim_intervalo'], 'safe'],
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
        $query = Relatorio::find()->joinWith('usuario');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['defaultOrder' => ['idrelatorio' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!\Yii::$app->user->can('admin')) {

            $query->andFilterWhere([
                'idrelatorio' => $this->idrelatorio,
                'datageracao' => $this->datageracao,
                'inicio_intervalo' => $this->inicio_intervalo,
                'fim_intervalo' => $this->fim_intervalo,
                'usuario_id' => Yii::$app->user->getId(),


            ]);

            $query->andFilterWhere(['like', 'nome', $this->nome])
                ->andFilterWhere(['like', 'tipo', $this->tipo]);
        }


        return $dataProvider;
    }
}
