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
            'idconta' => Yii::t('app', 'Idconta'),
            'valor' => Yii::t('app', 'Valor'),
            'descricao' => Yii::t('app', 'Descricao'),
            'tipoConta' => Yii::t('app', 'Tipo Conta'),
            'situacaoPagamento' => Yii::t('app', 'Situacao Pagamento'),
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
}
