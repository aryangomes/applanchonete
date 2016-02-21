<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property integer $idPedido
 * @property string $totalPedido
 * @property integer $idSituacaoAtual
 * @property integer $idComanda
 *
 * @property Historicosituacao[] $historicosituacaos
 * @property Situacaopedido[] $idSituacaoPedidos
 * @property Itempedido[] $itempedidos
 * @property Produto[] $idProdutos
 * @property Comanda $idComanda0
 * @property Situacaopedido $idSituacaoAtual0
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPedido', 'totalPedido', 'idSituacaoAtual', 'idComanda'], 'required'],
            [['idPedido', 'idSituacaoAtual', 'idComanda'], 'integer'],
            [['totalPedido'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPedido' => 'Id Pedido',
            'totalPedido' => 'Total Pedido',
            'idSituacaoAtual' => 'Id Situacao Atual',
            'idComanda' => 'Id Comanda',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricosituacaos()
    {
        return $this->hasMany(Historicosituacao::className(), ['idPedido' => 'idPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSituacaoPedidos()
    {
        return $this->hasMany(Situacaopedido::className(), ['idSituacaoPedido' => 'idSituacaoPedido'])->viaTable('historicosituacao', ['idPedido' => 'idPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItempedidos()
    {
        return $this->hasMany(Itempedido::className(), ['idPedido' => 'idPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProdutos()
    {
        return $this->hasMany(Produto::className(), ['idProduto' => 'idProduto'])->viaTable('itempedido', ['idPedido' => 'idPedido']);
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
    public function getIdSituacaoAtual0()
    {
        return $this->hasOne(Situacaopedido::className(), ['idSituacaoPedido' => 'idSituacaoAtual']);
    }
}
