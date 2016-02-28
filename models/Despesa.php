<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "despesa".
 *
 * @property integer $iddespesa
 * @property string $nomedespesa
 * @property double $valordespesa
 * @property integer $situacaopagamento
 * @property string $datavencimento
 */
class Despesa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'despesa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['nomedespesa', 'valordespesa', 'situacaopagamento'], 'required'],
        [['valordespesa'], 'number'],
        [['situacaopagamento'], 'integer'],
        [['datavencimento'], 'safe'],
        [['nomedespesa'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'iddespesa' => Yii::t('app', 'Iddespesa'),
        'nomedespesa' => Yii::t('app', 'Despesa'),
        'valordespesa' => Yii::t('app', 'Valor da Despesa'),
        'situacaopagamento' => Yii::t('app', 'Situação pagamento'),
        'datavencimento' => Yii::t('app', 'Data de vencimento'),
        ];
    }
}
