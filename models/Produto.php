<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property integer $idProduto
 * @property string $nome
 * @property string $preco
 * @property string $unidade
 * @property string $descricao
 * @property integer $idCategoria
 * @property string $dataValidade
 *
 * @property Estoque[] $estoques
 * @property InsumoProduto[] $insumoProdutos
 * @property Itemcardapio[] $itemcardapios
 * @property Cardapio[] $idCardapios
 * @property Itempedido[] $itempedidos
 * @property Pedido[] $idPedidos
 * @property ItensProduto[] $itensProdutos
 * @property Categoria $idCategoria0
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
            [['nome', 'preco', 'unidade', 'descricao', 'idCategoria'], 'required'],
            [['preco'], 'number'],
            [['descricao'], 'string'],
            [['idCategoria'], 'integer'],
            [['dataValidade'], 'safe'],
            [['nome'], 'string', 'max' => 100],
            [['unidade'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idProduto' => 'Id Produto',
            'nome' => 'Nome',
            'preco' => 'Preco',
            'unidade' => 'Unidade',
            'descricao' => 'Descricao',
            'idCategoria' => 'Id Categoria',
            'dataValidade' => 'Data Validade',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstoques()
    {
        return $this->hasMany(Estoque::className(), ['produto_idProduto' => 'idProduto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsumoProdutos()
    {
        return $this->hasMany(InsumoProduto::className(), ['produto_idProduto' => 'idProduto']);
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
    public function getIdCategoria0()
    {
        return $this->hasOne(Categoria::className(), ['idCategoria' => 'idCategoria']);
    }
}
