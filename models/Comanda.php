<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comanda".
 *
 * @property integer $idComanda
 * @property string $desconto
 * @property string $totalPago
 * @property string $dataHoraAbertura
 * @property string $dataHoraFechamento
 * @property string $descricao
 * @property integer $status
 * @property string $totalPedidos
 * @property integer $mesaIdMesa
 *
 * @property Mesa $mesaIdMesa0
 * @property Pagamento[] $pagamentos
 * @property Pedido[] $pedidos
 */
class Comanda extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comanda';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desconto', 'totalPago', 'totalPedidos'], 'number'],
            [['totalPago', 'dataHoraAbertura', 'dataHoraFechamento', 'mesaIdMesa'], 'required'],
            [['dataHoraAbertura', 'dataHoraFechamento'], 'safe'],
            [['descricao'], 'string'],
            [['status', 'mesaIdMesa'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idComanda' => 'Id Comanda',
            'desconto' => 'Desconto',
            'totalPago' => 'Total Pago',
            'dataHoraAbertura' => 'Data Hora Abertura',
            'dataHoraFechamento' => 'Data Hora Fechamento',
            'descricao' => 'Descricao',
            'status' => 'Status',
            'totalPedidos' => 'Total Pedidos',
            'mesaIdMesa' => 'Mesa Id Mesa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesaIdMesa0()
    {
        return $this->hasOne(Mesa::className(), ['idMesa' => 'mesaIdMesa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagamentos()
    {
        return $this->hasMany(Pagamento::className(), ['idComanda' => 'idComanda']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['idComanda' => 'idComanda']);
    }
}
