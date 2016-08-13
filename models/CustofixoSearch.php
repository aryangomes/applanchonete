<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Custofixo;

/**
 * CustofixoSearch represents the model behind the search form about `app\models\Custofixo`.
 */
class CustofixoSearch extends Custofixo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idconta', 'tipocustofixo_idtipocustofixo'], 'integer'],
            [['consumo'], 'number'],
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
        $query = Custofixo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
              'pagination' => [
                'pageSize' => 10,
            ],
               'sort'=> ['defaultOrder' => ['idconta'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idconta' => $this->idconta,
            'consumo' => $this->consumo,
            'tipocustofixo_idtipocustofixo' => $this->tipocustofixo_idtipocustofixo,
        ]);

        return $dataProvider;
    }


    /**
     * @param $idTipoFixoCusto
     * @return mixed
     */
    public function searchConsumoCustoFixoporTipoMensal($idTipoFixoCusto)
    {


        //Guarda o mês anterior
        $mes = (date('m')-1);

        //Guarda o último dia do mês
        $lastDayOfMonth = date('t', strtotime(date('Y') . '-' . $mes . '-' . date('d')));

        //Busca os custos fixo no período mensal(Do primeiro até o último dia do mês atual)
        $query = Custofixo::find()
            ->joinWith('idcontaAPagar')
            ->joinWith('idcontaAPagar.conta')
            ->where(['tipocustofixo_idtipocustofixo'=>$idTipoFixoCusto])
                ->andWhere(['between','dataVencimento',
                    date('Y').'-'.$mes.'-'.'01',  date('Y').'-'.$mes.'-'.$lastDayOfMonth]);

        //Guarda o valor médio de um tipo de custo fixo no período mensal(Do primeiro até o último dia do mês atual)
        $mediaConsumo = $query->average('valor');

        return $mediaConsumo;
      
    }
}
