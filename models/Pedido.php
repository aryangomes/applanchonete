<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property integer $idPedido
 * @property string $totalPedido
 * @property integer $idSituacaoAtual
 *
 * @property Historicosituacao[] $historicosituacaos
 * @property Situacaopedido[] $idSituacaoPedidos
 * @property Itempedido[] $itempedidos
 * @property Produto[] $idProdutos
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
        [['totalPedido'], 'double'],
        [['idSituacaoAtual'], 'required'],
        [['idSituacaoAtual'], 'integer'],
        [['situacaopedido'], 'safe'],
        [['idSituacaoAtual'], 'exist', 'skipOnError' => true, 'targetClass' => Situacaopedido::className(), 'targetAttribute' => ['idSituacaoAtual' => 'idSituacaoPedido']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idPedido' => Yii::t('app', 'Id Pedido'),
        'totalPedido' => Yii::t('app', 'Total Pedido'),
        'idSituacaoAtual' => Yii::t('app', 'Situação Atual'),
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
    public function getSituacaoPedidos()
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

    public function getSituacaopedido()
    {
        return $this->hasOne(Situacaopedido::className(), ['idSituacaoPedido' => 'idSituacaoAtual']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getPagamento()
    {
        return $this->hasOne(Pagamento::className(), ['idPedido' => 'idPedido']);
    }
}
