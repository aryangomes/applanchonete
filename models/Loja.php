<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loja".
 *
 * @property string $endereco
 * @property integer $user_id
 * @property string $nome
 *
 * @property User $user
 */
class Loja extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loja';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['endereco', 'user_id', 'nome'], 'required'],
            [['user_id'], 'integer'],
            [['endereco', 'nome'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'endereco' => Yii::t('app', 'Endereco'),
            'user_id' => Yii::t('app', 'User ID'),
            'nome' => Yii::t('app', 'Nome'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
