<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mesa".
 *
 * @property integer $idMesa
 * @property string $descricao
 * @property integer $disponivel
 * @property integer $alerta
 * @property string $qrcode
 * @property string $chave
 * @property integer $cont
 *
 * @property Comanda[] $comandas
 */
class Mesa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mesa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descricao', 'disponivel', 'alerta', 'qrcode', 'chave'], 'required'],
            [['disponivel', 'alerta', 'cont'], 'integer'],
            [['descricao', 'chave'], 'string', 'max' => 45],
            [['qrcode'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idMesa' => 'Id Mesa',
            'descricao' => 'Descricao',
            'disponivel' => 'Disponivel',
            'alerta' => 'Alerta',
            'qrcode' => 'Qrcode',
            'chave' => 'Chave',
            'cont' => 'Cont',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComandas()
    {
        return $this->hasMany(Comanda::className(), ['mesaIdMesa' => 'idMesa']);
    }
}
