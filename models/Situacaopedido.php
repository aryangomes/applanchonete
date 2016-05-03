<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "situacaopedido".
 *
 * @property integer $idSituacaoPedido
 * @property string $titulo
 * @property string $descricao
 *
 * @property Historicosituacao[] $historicosituacaos
 * @property Pedido[] $idPedidos
 * @property Pedido[] $pedidos
 */
class Situacaopedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'situacaopedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['titulo', 'descricao'], 'required'],
        [['descricao'], 'string'],
        [['titulo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idSituacaoPedido' => 'Id Situacao Pedido',
        'titulo' => 'Título',
        'descricao' => 'Descrição',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricosituacaos()
    {
        return $this->hasMany(Historicosituacao::className(), ['idSituacaoPedido' => 'idSituacaoPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPedidos()
    {
        return $this->hasMany(Pedido::className(), ['idPedido' => 'idPedido'])->viaTable('historicosituacao', ['idSituacaoPedido' => 'idSituacaoPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['idSituacaoAtual' => 'idSituacaoPedido']);
    }
}
