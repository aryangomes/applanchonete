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
        [['idprodutoVenda', 'idprodutoInsumo', 'quantidade', 'unidade', 'idprodutoInsumo[]'], 'required'],
        [['idprodutoVenda', 'idprodutoInsumo'], 'integer'],
        [['quantidade'], 'number'],
        [['unidade'], 'string', 'max' => 15]
        ];
    }

    public function validateIdsProdutosInsumos($attribute, $params)
    {
        if (!in_array($this->$attribute, ['USA', 'Web'])) {
            $this->addError($attribute, 'The country must be either "USA" or "Web".');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idprodutoVenda' => Yii::t('app', 'Produto Venda'),
        'idprodutoInsumo' => Yii::t('app', 'Insumo'),
        'quantidade' => Yii::t('app', 'Quantidade'),
        'unidade' => Yii::t('app', 'Unidade'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdprodutoVenda()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idprodutoVenda']);
    }

    public function getIdprodutoInsumo()
    {
        return $this->hasOne(Produto::className(), ['idProduto' => 'idprodutoInsumo']);
    }

    public function getNomeinsumo()
    {
        return Produto::find()->where(['idProduto'=>$this->idprodutoInsumo])->one()->nome;
    }

    public function getNomeprodutovenda()
    {
        return Produto::find()->where(['idProduto'=>$this->idprodutoVenda])->one()->nome;
    }
}
