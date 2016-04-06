<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "itempedido".
 *
 * @property integer $idPedido
 * @property integer $idProduto
 * @property string $quantidade
 * @property string $total
 *
 * @property Pedido $idPedido0
 * @property Produto $idProduto0
 */
class Itempedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'itempedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['idPedido', 'idProduto', 'quantidade', 'total'], 'required'],
        [['idPedido', 'idProduto'], 'integer'],
        [['quantidade', 'total'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idPedido' => 'Id Pedido',
        'idProduto' => 'Id Produto',
        'quantidade' => 'Quantidade',
        'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getpedidos()
    {
        return $this->hasOne(Pedido::className(), ['idPedido' => 'idPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getprodutos()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idProduto']);
    }
    
}
