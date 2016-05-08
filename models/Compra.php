<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "compra".
 *
 * @property integer $idconta
 * @property string $dataCompra
 *
 * @property Conta $idconta0
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
            [['idconta', 'dataCompra'], 'required'],
            [['idconta'], 'integer'],
            [['dataCompra'], 'safe'],
            [['idconta'], 'exist', 'skipOnError' => true, 'targetClass' => Conta::className(), 'targetAttribute' => ['idconta' => 'idconta']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idconta' => Yii::t('app', 'Idconta'),
            'dataCompra' => Yii::t('app', 'Data Compra'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdconta0()
    {
        return $this->hasOne(Conta::className(), ['idconta' => 'idconta']);
    }
}
