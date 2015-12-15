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
        [['cnpj'], 'string', 'max' => 14],
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
        'cnpj' => Yii::t('app', 'CNPJ'),
        'nome' => Yii::t('app', 'Nome'),
        'endereco' => Yii::t('app', 'Endereço'),
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
}
