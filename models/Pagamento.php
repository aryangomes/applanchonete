<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pagamento".
 *
 * @property integer $idPagamento
 * @property string $valor
 * @property string $dataHora
 * @property string $descricao
 * @property integer $tipoPagamento_idTipoPagamento
 * @property integer $idComanda
 *
 * @property Comanda $idComanda0
 * @property Tipopagamento $tipoPagamentoIdTipoPagamento
 */
class Pagamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pagamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor'], 'number'],
            [['dataHora', 'tipoPagamento_idTipoPagamento', 'idComanda'], 'required'],
            [['dataHora'], 'safe'],
            [['tipoPagamento_idTipoPagamento', 'idComanda'], 'integer'],
            [['descricao'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPagamento' => 'Id Pagamento',
            'valor' => 'Valor',
            'dataHora' => 'Data Hora',
            'descricao' => 'Descricao',
            'tipoPagamento_idTipoPagamento' => 'Tipo Pagamento Id Tipo Pagamento',
            'idComanda' => 'Id Comanda',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdComanda0()
    {
        return $this->hasOne(Comanda::className(), ['idComanda' => 'idComanda']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoPagamentoIdTipoPagamento()
    {
        return $this->hasOne(Tipopagamento::className(), ['idTipoPagamento' => 'tipoPagamento_idTipoPagamento']);
    }
}
