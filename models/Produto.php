<?php

namespace app\models;

use Yii;
use app\models\ProdutoSearch;

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
 * @property Insumo $insumo
 * @property Itemcardapio[] $itemcardapios
 * @property Cardapio[] $idCardapios
 * @property Itempedido[] $itempedidos
 * @property Pedido[] $idPedidos
 * @property ItensProduto[] $itensProdutos
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $datainicioavaliacao;
    public $datafimavaliacao;
    public $groupbyavaliacao;

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
            [['nome', 'isInsumo', 'idCategoria']
                , 'required'],
            [['quantidadeMinima', 'quantidadeEstoque'], 'number'],
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
            'idCategoria' => Yii::t('app', 'Categoria'),
            'quantidadeEstoque' => Yii::t('app', 'Quantidade em Estoque'),
            'datainicioavaliacao' => Yii::t('app', 'De'),
            'datafimavaliacao' => Yii::t('app', 'Até'),
            'groupbyavaliacao' => Yii::t('app', 'Agrupar por'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsumos()
    {
        return $this->hasOne(Insumo::className(), ['idprodutoVenda' => 'idProduto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdprodutoInsumo()
    {
        return $this->hasOne(Insumo::className(), ['idprodutoInsumo' => 'idProduto']);
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

    /**
     * @return string
     * Retorna o nome da Categoria do Produto
     */
    public function getNomeCategoria()
    {
        return Categoria::find()->where(['idCategoria' => $this->idCategoria])->one()->nome;
    }

    /**
     * @param $idprodutoVenda
     * @return float|int
     * Calcula os custos de um Produto Venda, de acordo com o preço de compra(Valor da compra mais
     * atual) de um insumo e também de acordo com os custos fixos(Total de produtos vendidos/ total consumo
     * em um mês)
     *
     */
    public function calculoPrecoProduto($idprodutoVenda)
    {

        //Busca e guarda todos os insumos do Produto Venda
        $insumos = Insumo::find()->where(['idprodutoVenda' => $idprodutoVenda])->all();
        $precosugerido = 0;

        //Model para a busca dos dados de Produto
        $searchModel = new ProdutoSearch();

        //Guarda a soma da quantidade de Produtos Venda vendidos no mês
        $sumQuantidadeVendaProdutoVenda = $searchModel->searchQuantidadeProdutosEmVendas($idprodutoVenda);


        //Busca e guarda todos os tipos de Custo Fixo
        $tiposCustoFixo = Tipocustofixo::find()->all();
        $consumosCustoFixo = [];

        //Model para a busca dos dados de Custo Fixo
        $searchModelCustoFixo = new CustofixoSearch();

        $arrayTipoCustoFixoZero = [];

        //Guarda o consumo mensal de cada tipo de Custo Fixo
        foreach ($tiposCustoFixo as $custoFixo) {
            $consumoCustoFixo = $searchModelCustoFixo
                ->searchConsumoCustoFixoporTipoMensal($custoFixo->idtipocustofixo, date('m'));
            array_push($consumosCustoFixo, $consumoCustoFixo);
            if($consumoCustoFixo > 0){
                $ct = ($sumQuantidadeVendaProdutoVenda / $consumoCustoFixo);
                $precosugerido += $ct;
            }else{
                    array_push($arrayTipoCustoFixoZero,$custoFixo->tipocustofixo);

            }
        }

        if(isset($arrayTipoCustoFixoZero)){
            Yii::$app->session->setFlash('custofixozerados', "<div class=\"alert alert-warning\">
   Não foram calculados os custos fixos de ".implode(",",$arrayTipoCustoFixoZero)." pois não
    há registro(s) dele(s) no mês anterior
</div>");
        }

        //Soma o(s) valor(es) médio(s) de custos fixos do mês ao custo do produto
       /* foreach ($consumosCustoFixo as $custo) {
            if($custo > 0){
            $ct = ($sumQuantidadeVendaProdutoVenda / $custo);
            $precosugerido += $ct;
            }else{
                echo "Não há vendas no mês anterior";
            }
        }*/

        //Soma o(s) valor(es) do(s) insumo(s) do produto venda ao custo do produto
        foreach ($insumos as $key => $insumo) {
            $produtoCompra = ($searchModel->searchProdutosCompra($insumo->idprodutoInsumo));

            $precosugerido +=
                (($produtoCompra->valorCompra * $insumo->quantidade) / $produtoCompra->quantidade);

        }


        return $precosugerido;

    }

}
