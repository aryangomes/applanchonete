<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contasareceber".
 *
 * @property integer $idconta
 * @property string $dataHora
 *
 * @property Conta $idconta0
 */
class Contasareceber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contasareceber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['idconta'], 'required'],
        [['idconta'], 'integer'],
        [['dataHora'], 'safe'],
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
        'dataHora' => Yii::t('app', 'Data Hora'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdconta0()
    {
        return $this->hasOne(Conta::className(), ['idconta' => 'idconta']);
    }

    public function getConta()
    {
        return $this->hasOne(Conta::className(), ['idconta' => 'idconta']);
    }
}
