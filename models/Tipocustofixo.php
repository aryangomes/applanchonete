<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipocustofixo".
 *
 * @property integer $idtipocustofixo
 * @property string $tipocustofixo
 *
 * @property Custofixo[] $custofixos
 */
class Tipocustofixo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipocustofixo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipocustofixo'], 'required'],
            [['tipocustofixo'], 'string', 'max' => 70],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtipocustofixo' => Yii::t('app', 'Idtipocustofixo'),
            'tipocustofixo' => Yii::t('app', 'Tipo de Custo Fixo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustofixos()
    {
        return $this->hasMany(Custofixo::className(), ['tipocustofixo_idtipocustofixo' => 'idtipocustofixo']);
    }
}
