<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compraproduto".
 *
 * @property integer $idCompra
 * @property integer $idProduto
 * @property double $quantidade
 * @property double $valorCompra
 *
 * @property Compra $idCompra0
 * @property Produto $idProduto0
 */
class Compraproduto extends \yii\db\ActiveRecord
{

    public $valorAlterado;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'compraproduto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['idCompra', 'idProduto', 'quantidade', 'valorCompra'], 'required'],
        [['idCompra', 'idProduto'], 'integer'],
        [['quantidade', 'valorCompra'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idCompra' => Yii::t('app', 'Compra'),
        'idProduto' => Yii::t('app', 'Produto'),
        'quantidade' => Yii::t('app', 'Quantidade'),
        'valorCompra' => Yii::t('app', 'Valor da Compra(R$)'),
        ];
    }

   

    public function getConta()
    {
        return $this->hasOne(Conta::className(), ['idconta' => 'idCompra']);
    }

    public function getProduto()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idProduto']);
    }

    public function comparaPrecoProduto($objCompraProduto){

        $precoAntigo = Yii::$app->db->createCommand('SELECT valorCompra FROM compraproduto
            WHERE idProduto = :id ORDER BY idCompra DESC LIMIT 1', ['id' => $objCompraProduto['idProduto']])->queryOne();

        $precoAntigoFloat = (float) $precoAntigo['valorCompra'];
        $novoPrecoFloat = (float)$objCompraProduto['valorCompra'];


        if ($precoAntigoFloat == $novoPrecoFloat) {
            return false;
        } else{
            return true;
        }
    }
}


