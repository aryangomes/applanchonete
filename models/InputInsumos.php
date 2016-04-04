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
class InputInsumos extends \yii\db\ActiveRecord
{

   public $numeroinputs;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inputinsumos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

     return [ [['numeroinputs'], 'integer']];
 }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'numeroinputs' => Yii::t('app', 'numeroinputs'),

        ];
    }
}
