<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compra".
 *
 * @property integer $idconta
 * @property double $valor
 * @property string $descricao
 * @property string $tipoConta
 * @property integer $situacaoPagamento
 * @property string $dataVencimento
 * @property string $dataCompra
 *
 * @property Compraproduto[] $compraprodutos
 * @property Produto[] $idProdutos
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
            [['idconta', 'valor', 'tipoConta', 'situacaoPagamento', 'dataCompra'], 'required'],
            [['idconta', 'situacaoPagamento'], 'integer'],
            [['valor'], 'number'],
            [['descricao'], 'string'],
            [['dataVencimento', 'dataCompra'], 'safe'],
            [['tipoConta'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idconta' => Yii::t('app', 'Idconta'),
            'valor' => Yii::t('app', 'Valor'),
            'descricao' => Yii::t('app', 'Descricao'),
            'tipoConta' => Yii::t('app', 'Tipo Conta'),
            'situacaoPagamento' => Yii::t('app', 'Situacao Pagamento'),
            'dataVencimento' => Yii::t('app', 'Data Vencimento'),
            'dataCompra' => Yii::t('app', 'Data Compra'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompraprodutos()
    {
        return $this->hasMany(Compraproduto::className(), ['idCompra' => 'idconta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProdutos()
    {
        return $this->hasMany(Produto::className(), ['idProduto' => 'idProduto'])->viaTable('compraproduto', ['idCompra' => 'idconta']);
    }
}
