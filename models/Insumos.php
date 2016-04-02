<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "insumos".
 *
 * @property integer $idprodutoVenda
 * @property integer $idprodutoInsumo
 * @property double $quantidade
 * @property string $unidade
 *
 * @property Produto $idprodutoVenda0
 */
class Insumos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'insumos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idprodutoVenda', 'idprodutoInsumo', 'quantidade', 'unidade'], 'required'],
            [['idprodutoVenda', 'idprodutoInsumo'], 'integer'],
            [['quantidade'], 'number'],
            [['unidade'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idprodutoVenda' => Yii::t('app', 'Idproduto Venda'),
            'idprodutoInsumo' => Yii::t('app', 'Idproduto Insumo'),
            'quantidade' => Yii::t('app', 'Quantidade'),
            'unidade' => Yii::t('app', 'Unidade'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdprodutoVenda0()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idprodutoVenda']);
    }
}
