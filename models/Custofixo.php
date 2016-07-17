<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "custofixo".
 *
 * @property integer $idconta
 * @property double $consumo
 * @property integer $tipocustofixo_idtipocustofixo
 *
 * @property Contasapagar $idconta0
 * @property Tipocustofixo $tipocustofixoIdtipocustofixo
 */
class Custofixo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'custofixo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idconta', ], 'required'],
            [['idconta', 'tipocustofixo_idtipocustofixo'], 'integer'],
            [['consumo'], 'number'],
            [['idconta'], 'exist', 'skipOnError' => true, 'targetClass' => Contasapagar::className(), 'targetAttribute' => ['idconta' => 'idconta']],
            [['tipocustofixo_idtipocustofixo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipocustofixo::className(), 'targetAttribute' => ['tipocustofixo_idtipocustofixo' => 'idtipocustofixo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idconta' => Yii::t('app', 'Idconta'),
            'consumo' => Yii::t('app', 'Consumo'),
            'tipocustofixo_idtipocustofixo' => Yii::t('app', 'Tipocustofixo Idtipocustofixo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcontaAPagar()
    {
        return $this->hasOne(Contasapagar::className(), ['idconta' => 'idconta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipocustofixoIdtipocustofixo()
    {
        return $this->hasOne(Tipocustofixo::className(), ['idtipocustofixo' => 'tipocustofixo_idtipocustofixo']);
    }
}
