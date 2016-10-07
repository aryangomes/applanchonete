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

    const EM_ANDAMENTO = 1;

    const CONCLUIDO = 2;

    const CANCELADO = 3;

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
            [['idSituacaoAtual', 'idMesa'], 'required'],
            [['idSituacaoAtual', 'idMesa'], 'integer'],
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
            'idMesa' => Yii::t('app', 'Mesa'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricosituacaos()
    {
        return $this->hasOne(Historicosituacao::className(), ['idPedido' => 'idPedido']);
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

    /**
     * Retorna a data hora da situação do pedido
     */
    public function getDataHoraPedido()
    {

        return isset(Historicosituacao::find()->where(
                ['idPedido' => $this->idPedido]
            )->orderBy('dataHora DESC')->one()->dataHora) ?
            Historicosituacao::find()->where(
                ['idPedido' => $this->idPedido]
            )->orderBy('dataHora DESC')->one()->dataHora : null;
    }


    /**
     * Retorna os itens do pedido para o index de Pedido
     * @return array|null
     */
    public function getItensPedido()
    {
        $itensPedido = Itempedido::findAll($this->idPedido);
        $results = [];
        $aux = [];


        if (count($itensPedido) > 0) {
            $aux = [];
            foreach ($itensPedido as $ip) {
                $produto = Produto::findOne($ip->idProduto);
                if ($produto != null) {
                    array_push($aux, [$produto->nome, $ip->quantidade]);
                }

            }

            return $aux;
        } else {
            return null;
        }
    }


    /**
     * Insere uma nova situação de pedido ao histórico da situação do pedido
     * @param $novaSituacao
     * @return bool
     */
    public function mudarHistoricoSituacaoPedido($novaSituacao)
    {
        $historicoPedido = Historicosituacao::findOne([$this->idPedido, $this->idSituacaoAtual]);
        if ($historicoPedido != null) {

            $historicoPedido = new Historicosituacao();
            $historicoPedido->idPedido = $this->idPedido;
            $historicoPedido->idSituacaoPedido = $novaSituacao;

            date_default_timezone_set('America/Sao_Paulo');

            $historicoPedido->dataHora = date('Y-m-d H:i');
            if ($historicoPedido->save()) {

                return true;
            } else {

                return false;
            }
        } else {
            return false;
        }
    }
}
