<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contasapagar".
 *
 * @property integer $idconta
 * @property integer $situacaoPagamento
 * @property string $dataVencimento
 *
 * @property Conta $idconta0
 */
class Contasapagar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contasapagar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idconta'], 'required'],
            [['idconta'], 'integer'],
            [['dataVencimento'], 'safe'],
            [['idconta'], 'exist', 'skipOnError' => true, 'targetClass' => Conta::className(), 'targetAttribute' => ['idconta' => 'idconta']],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idconta' => Yii::t('app', 'Conta'),
        'dataVencimento' => Yii::t('app', 'Data Vencimento'),
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
