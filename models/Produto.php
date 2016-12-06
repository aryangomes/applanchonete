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
 * @property resource $foto
 * @property resource $imageFile
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
    public $imageFile;
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
            [['foto'], 'string'],
            [['nome'], 'string', 'max' => 100],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
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
            'quantidadeMinima' => Yii::t('app', 'Estoque mínimo'),
            'idCategoria' => Yii::t('app', 'Categoria'),
            'quantidadeEstoque' => Yii::t('app', 'Quantidade em Estoque'),
            'datainicioavaliacao' => Yii::t('app', 'De'),
            'datafimavaliacao' => Yii::t('app', 'Até'),
            'groupbyavaliacao' => Yii::t('app', 'Agrupar por'),
            'foto' => Yii::t('app', 'Foto'),
            'imageFile' => Yii::t('app', 'Foto'),
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
    public function getIdCategoria()
    {
        return $this->hasOne(Categoria::className(), ['idCategoria' => 'idCategoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
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
                ->searchConsumoCustoFixoporTipoMensal($custoFixo->idtipocustofixo);

            array_push($consumosCustoFixo, $consumoCustoFixo);

            if ($consumoCustoFixo > 0) {
                $ct = ($sumQuantidadeVendaProdutoVenda / $consumoCustoFixo);

                $precosugerido += $ct;

            } else {

                array_push($arrayTipoCustoFixoZero, $custoFixo->tipocustofixo);

            }
        }

        if (($arrayTipoCustoFixoZero) != null) {

            Yii::$app->session->setFlash('custofixozerados', "<div class=\"alert alert-warning\">
               Não foram calculados os custos fixos de " . implode(",", $arrayTipoCustoFixoZero) . " pois não
                há registro(s) dele(s) no mês anterior
            </div>");
        }


        //Soma o(s) valor(es) do(s) insumo(s) do produto venda ao custo do produto
        foreach ($insumos as $key => $insumo) {

            $produtoCompra = ($searchModel->searchProdutosCompra($insumo->idprodutoInsumo));

            if($insumo != null && $produtoCompra != null ){

                $precosugerido +=
                    (($produtoCompra->valorCompra * $insumo->quantidade) / $produtoCompra->quantidade);
            }

        }

        return $precosugerido;

    }

    /**
     * @return array|null
     * Gera a lista dos produtos cadastrados
     */
    public static function getListToDropDownList()
    {
        $options = [];

        $optGroups = Categoria::find()->all();

        foreach ($optGroups as $categoria) {
            $produtosCategoria = [];
            $produtos = Produto::find()->
            where(['idCategoria' => $categoria->idCategoria])->all();

            foreach ($produtos as $p) {
                $key = $p->idProduto;
                $produtosCategoria[$key] = $p->nome;
            }

            $options[$categoria->nome] = $produtosCategoria;

        }

        return $options;
    }

    /**
     * Verifica a quantidade no estoque antes de efetuar um
     * pedido
     * @param $qtdProdutoPedido int
     * @return bool
     */
    public function verificaQtdEstProdutoPedido($qtdProdutoPedido)
    {
        $produto = Produto::findOne($this->idProduto);

        if ($produto != null & $qtdProdutoPedido > 0) {

            if (($produto->quantidadeEstoque - $qtdProdutoPedido) >
                $produto->quantidadeMinima
            ) {

                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function getListaInsumos($id){
        $produtos = Yii::$app->db->createCommand('SELECT idprodutoVenda FROM insumo
            WHERE idprodutoInsumo = :id ', ['id' => $id])->queryAll();

       /* $resultados = [];

        foreach($produtos as $resultado){
            array_push($resultados, $resultado['idprodutoVenda']);
        }
        */
        return $produtos;
    }

}
