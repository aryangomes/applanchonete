<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fornecedor".
 *
 * @property string $cnpj
 * @property string $nome
 * @property string $endereco
 * @property integer $idFornecedor
 *
 * @property Compra[] $compras
 */
class Fornecedor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fornecedor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['cnpj', 'nome'], 'required'],
        [['cnpj'], 'string', 'max' => 18],
        [['nome', 'endereco'], 'string', 'max' => 100],
        [['cnpj'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'cnpj' => Yii::t('app', 'CNPJ do Fornecedor'),
        'nome' => Yii::t('app', 'Nome do Fornecedor'),
        'endereco' => Yii::t('app', 'Endereço do Fornecedor'),
        'idFornecedor' => Yii::t('app', 'Id Fornecedor'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompras()
    {
        return $this->hasMany(Compra::className(), ['fornecedor_idFornecedor' => 'idFornecedor']);
    }

    public function getNomeFornecedor($idFornecedor)
    {
        return Fornecedor::find('nome')->where(['idFornecedor'=>$idFornecedor])->one();

       // return $this->find('nome')->where(['idFornecedor'=>$idFornecedor])->all();
    }
}
