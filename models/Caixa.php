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
 * @property integer $user_id
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
            [['valorapurado', 'valoremcaixa', 'valorlucro', 'user_id'], 'required'],
            [['valorapurado', 'valoremcaixa', 'valorlucro'], 'number'],
            [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcaixa' => Yii::t('app', 'Idcaixa'),
            'valorapurado' => Yii::t('app', 'Valorapurado'),
            'valoremcaixa' => Yii::t('app', 'Valoremcaixa'),
            'valorlucro' => Yii::t('app', 'Valorlucro'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
}
