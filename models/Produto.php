<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property integer $idProduto
 * @property string $nome
 * @property double $valorVenda
 * @property integer $isInsumo
 * @property double $quantidadeMinima
 * @property integer $idCategoria
 * @property double $quantidadeEstoque
 *
 * @property Insumos $insumos
 * @property Itemcardapio[] $itemcardapios
 * @property Cardapio[] $idCardapios
 * @property Itempedido[] $itempedidos
 * @property Pedido[] $idPedidos
 * @property ItensProduto[] $itensProdutos
 * @property Categoria $idCategoria
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['nome', 'valorVenda', 'isInsumo', 'idCategoria'], 'required'],
        [['valorVenda', 'quantidadeMinima', 'quantidadeEstoque'], 'number'],
        [['isInsumo', 'idCategoria'], 'integer'],
        [['nome'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idProduto' => Yii::t('app', 'Id Produto'),
        'nome' => Yii::t('app', 'Nome'),
        'valorVenda' => Yii::t('app', 'Valor Venda'),
        'isInsumo' => Yii::t('app', 'Is Insumo'),
        'quantidadeMinima' => Yii::t('app', 'Quantidade Minima'),
        'idCategoria' => Yii::t('app', 'Id Categoria'),
        'quantidadeEstoque' => Yii::t('app', 'Quantidade Estoque'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsumos()
    {
        return $this->hasOne(Insumos::className(), ['idprodutoVenda' => 'idProduto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemcardapios()
    {
        return $this->hasMany(Itemcardapio::className(), ['idProduto' => 'idProduto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCardapios()
    {
        return $this->hasMany(Cardapio::className(), ['idCardapio' => 'idCardapio'])->viaTable('itemcardapio', ['idProduto' => 'idProduto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItempedidos()
    {
        return $this->hasMany(Itempedido::className(), ['idProduto' => 'idProduto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPedidos()
    {
        return $this->hasMany(Pedido::className(), ['idPedido' => 'idPedido'])->viaTable('itempedido', ['idProduto' => 'idProduto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItensProdutos()
    {
        return $this->hasMany(ItensProduto::className(), ['produto_idProduto' => 'idProduto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria()
    {
        return $this->hasOne(Categoria::className(), ['idCategoria' => 'idCategoria']);
    }
}
