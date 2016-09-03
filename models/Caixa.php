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
 * @property string $dataabertura
 * @property string $datafechamento
 *
 * @property User $user
 */
class Caixa extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'caixa';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['valorapurado', 'valoremcaixa', 'valorlucro'], 'number'],
            [['user_id'], 'integer'],
            [['dataabertura'], 'required'],
            [['dataabertura', 'datafechamento'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'idcaixa' => Yii::t('app', 'Idcaixa'),
            'valorapurado' => Yii::t('app', 'Valor Apurado'),
            'valoremcaixa' => Yii::t('app', 'Valor em Caixa'),
            'valorlucro' => Yii::t('app', 'Valor Lucro'), 

            'user_id' => Yii::t('app', 'User ID'),
            'dataabertura' => Yii::t('app', 'Dataabertura'),
            'datafechamento' => Yii::t('app', 'Datafechamento'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Retorna o caixa atualmente aberto
     * @param $idUser
     * @return \yii\db\ActiveQuery
     */
    public function getCaixaAberto($idUser) {
        return self::find()->where(['user_id'=>$idUser])
            ->andWhere(['not', ['dataabertura' => null]])
            ->andWhere( ['datafechamento' => null])
            ->one();
    }

}
