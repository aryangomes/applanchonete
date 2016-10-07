<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "conta".
 *
 * @property integer $idconta
 * @property double $valor
 * @property string $descricao
 * @property string $tipoConta
 * @property integer $situacaoPagamento
 *
 * @property Compra $compra
 * @property Contasapagar $contasapagar
 * @property Contasareceber $contasareceber
 */
class Conta extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor'], 'number'],
            [['descricao'], 'string'],
            [['tipoConta','valor','situacaoPagamento'], 'required'],
            [['situacaoPagamento'], 'integer'],
            [['tipoConta'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idconta' => Yii::t('app', 'Conta'),
            'valor' => Yii::t('app', 'Valor da Conta'),
            'descricao' => Yii::t('app', 'Descrição'),
            'tipoConta' => Yii::t('app', 'Tipo de Conta'),
            'situacaoPagamento' => Yii::t('app', 'Situação do Pagamento'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompra()
    {
        return $this->hasOne(Compra::className(), ['idconta' => 'idconta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContasapagar()
    {
        return $this->hasOne(Contasapagar::className(), ['idconta' => 'idconta']);
    }



    public function getContaapagar($idconta)
    {
        return Contasapagar::findOne($idconta);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContasareceber()
    {
        return $this->hasOne(Contasareceber::className(), ['idconta' => 'idconta']);
    }

    public function getContaareceber($idconta)
    {
        return Contasareceber::findOne($idconta);
    }

    
    
    /**
     * @param $idconta
     * @return Custofixo
     */
    public function getCustofixo()
    {
        return $this->hasOne(Custofixo::className(), ['idconta' => 'idconta']);
    }


    /**
     * Retorna o tipo de conta
     * @return string
     */
    public function getTipoConta()
    {
        $tiposConta = ['contasapagar' => 'Conta a pagar', 'contasareceber' => 'Conta a receber',
            'custofixo' => 'Custo Fixo'];
        return $tiposConta[$this->tipoConta];
    }
}
