<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compra".
 *
 * @property string $datacompra
 * @property double $totalcompra
 * @property integer $idcompra
 * @property integer $fornecedor_idFornecedor
 *
 * @property Fornecedor $fornecedorIdFornecedor
 * @property ProdutosCompra[] $produtosCompras
 */
class Compra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'compra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['datacompra', 'fornecedor_idFornecedor'], 'required'],
        [['datacompra'], 'safe'],
        [['totalcompra'], 'number'],
        [['fornecedor_idFornecedor'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'datacompra' => Yii::t('app', 'Data da compra'),
        'totalcompra' => Yii::t('app', 'Total compra'),
        'idcompra' => Yii::t('app', 'Idcompra'),
        'fornecedor_idFornecedor' => Yii::t('app', 'Fornecedor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedorIdFornecedor()
    {
        return $this->hasOne(Fornecedor::className(), ['idFornecedor' => 'fornecedor_idFornecedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProdutosCompras()
    {
        return $this->hasMany(ProdutosCompra::className(), ['compra_idcompra' => 'idcompra']);
    }
}
