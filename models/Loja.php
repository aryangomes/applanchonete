<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "loja".
 *
 * @property string $nome
 * @property string $endereco
 *
 * @property Usuario[] $usuarios
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
        [['nome', 'endereco'], 'required'],
        [['nome', 'endereco'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'nome' => Yii::t('app', 'Nome'),
        'endereco' => Yii::t('app', 'Endereço'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['loja_nome' => 'nome']);
    }
}
