<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "caixa".
 *
 * @property integer $idcaixa
 * @property double $valorapurado
 * @property double $valoremcaixa
 * @property double $valorlucro
 */
class Caixa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'caixa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['valorapurado', 'valoremcaixa', 'valorlucro'], 'required'],
        [['valorapurado', 'valoremcaixa', 'valorlucro'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idcaixa' => Yii::t('app', 'Idcaixa'),
        'valorapurado' => Yii::t('app', 'Valor Apurado'),
        'valoremcaixa' => Yii::t('app', 'Valor em Caixa'),
        'valorlucro' => Yii::t('app', 'Valor do Lucro'),
        ];
    }
}
