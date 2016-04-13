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
        'idCompra' => Yii::t('app', 'Id Compra'),
        'idProduto' => Yii::t('app', 'Id Produto'),
        'quantidade' => Yii::t('app', 'Quantidade'),
        'valorCompra' => Yii::t('app', 'Valor Compra'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCompra()
    {
        return $this->hasOne(Compra::className(), ['idconta' => 'idCompra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduto()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idProduto']);
    }
}