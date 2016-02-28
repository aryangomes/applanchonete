<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historicosituacao".
 *
 * @property integer $idPedido
 * @property integer $idSituacaoPedido
 * @property string $dataHora
 *
 * @property Pedido $idPedido0
 * @property Situacaopedido $idSituacaoPedido0
 */
class Historicosituacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'historicosituacao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPedido', 'idSituacaoPedido', 'dataHora'], 'required'],
            [['idPedido', 'idSituacaoPedido'], 'integer'],
            [['dataHora'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPedido' => 'Id Pedido',
            'idSituacaoPedido' => 'Id Situacao Pedido',
            'dataHora' => 'Data Hora',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPedido0()
    {
        return $this->hasOne(Pedido::className(), ['idPedido' => 'idPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSituacaoPedido0()
    {
        return $this->hasOne(Situacaopedido::className(), ['idSituacaoPedido' => 'idSituacaoPedido']);
    }
}
