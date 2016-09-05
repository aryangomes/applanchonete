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
            [['tipoConta'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idconta' => Yii::t('app', 'Conta'),
            'valor' => Yii::t('app', 'Valor'),
            'descricao' => Yii::t('app', 'Descrição'),
            'tipoConta' => Yii::t('app', 'Tipo de Conta'),
            'situacaoPagamento' => Yii::t('app', 'Situação de Pagamento'),
            'dataVencimento' => Yii::t('app', 'Data de Vencimento'),
            'dataCompra' => Yii::t('app', 'Data da Compra'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConta()
    {
        return $this->hasOne(Conta::className(), ['idconta' => 'idconta']);
    }
}
