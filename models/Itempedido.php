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
        [['quantidade', 'total'], 'number'],
        [['idPedido'], 'exist', 'skipOnError' => true, 'targetClass' => Pedido::className(), 'targetAttribute' => ['idPedido' => 'idPedido']],
        [['idProduto'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::className(), 'targetAttribute' => ['idProduto' => 'idProduto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idPedido' => Yii::t('app', 'Pedido'),
        'idProduto' => Yii::t('app', 'Produto'),
        'quantidade' => Yii::t('app', 'Quantidade'),
        'total' => Yii::t('app', 'Total'),
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
    public function getIdProduto0()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idProduto']);
    }
}
