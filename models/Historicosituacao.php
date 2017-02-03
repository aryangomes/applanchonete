<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historicosituacao".
 *
 * @property integer $idPedido
 * @property integer $idSituacaoPedido
 * @property string $dataHora
 *
 * @property integer $user_id
 *
 * @property User $user
 * @property Pedido $idPedido0
 * @property Situacaopedido $idSituacaoPedido0
 */
class Historicosituacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'historicosituacao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idPedido', 'idSituacaoPedido', 'dataHora', 'user_id'], 'required'],
            [['idPedido', 'idSituacaoPedido', 'user_id'], 'integer'],
            [['dataHora'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['idSituacaoPedido'], 'exist', 'skipOnError' => true, 'targetClass' => Situacaopedido::className(), 'targetAttribute' => ['idSituacaoPedido' => 'idSituacaoPedido']],
            [['idPedido'], 'exist', 'skipOnError' => true, 'targetClass' => Pedido::className(), 'targetAttribute' => ['idPedido' => 'idPedido']],];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPedido' => 'Pedido',
            'idSituacaoPedido' => 'Situação Pedido',
            'dataHora' => 'Data e Hora',
            'user_id' => Yii::t('app', 'Usuário'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedido()
    {
        return $this->hasOne(Pedido::className(), ['idPedido' => 'idPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSituacaoPedido()
    {
        return $this->hasOne(Situacaopedido::className(), ['idSituacaoPedido' => 'idSituacaoPedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

   public function getUser()
   {

       return $this->hasOne(User::className(), ['id' => 'user_id']);
   }
}
