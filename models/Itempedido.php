<?php

namespace app\models;

use Yii;
use app\models\Produto;

/**
 * This is the model class for table "itempedido".
 *
 * @property integer $idPedido
 * @property integer $idProduto
 * @property string $quantidade
 * @property float $total
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
            [['idPedido', 'idProduto', 'quantidade'], 'required'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNomeProduto()
    {
        return Produto::find()->where(['idProduto' => $this->idProduto])->one()->nome;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedido()
    {
        return $this->hasOne(Pedido::className(), ['idPedido' => 'idPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idProduto']);
    }

    /**
     *
     */
    public function removerItemPedido()
    {


        if (Insumo::atualizaQtdNoEstoqueDelete($this->idProduto, $this->quantidade)) {
            $this->delete();
        }

    }

    /**
     * Verifica a quantidade no estoque antes de efetuar um
     * pedido
     * @params $idProduto int, $qtdProdutoPedido int
     * @return array
     */
    public function verificaQtdEstProdutoPedido($idProduto, $qtdProdutoPedido)
    {
        //Receba o produto
        $produto = Produto::findOne($idProduto);

        //Recebe o insumo que está com o estoque com quantidade mínima
        $insumoFaltando = [];

        if ($produto != null & $qtdProdutoPedido > 0) {

            $insumosProduto = Insumo::findAll(['idprodutoVenda' => $idProduto]);

            if (count($insumosProduto) > 0) {


                foreach ($insumosProduto as $inspro) {

                    $insumo = Produto::findOne($inspro->idprodutoInsumo);

                    if ($insumo != null) {

                        if (($insumo->quantidadeEstoque - ($inspro->quantidade * $qtdProdutoPedido)) <
                            $insumo->quantidadeMinima) {

                            array_push($insumoFaltando,$insumo);
                        }
                    }

                }


            }

        }
        return $insumoFaltando;
    }

}
