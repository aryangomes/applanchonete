<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pagamento".
 *
 * @property integer $idTipoPagamento
 * @property integer $idConta
 * @property integer $idPedido
 */
class Pagamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pagamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTipoPagamento', 'idConta', 'idPedido'], 'required'],
            [['idTipoPagamento', 'idConta', 'idPedido'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTipoPagamento' => Yii::t('app', 'Tipo de Pagamento'),
            'idConta' => Yii::t('app', 'Id Conta'),
            'idPedido' => Yii::t('app', 'Id Pedido'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

        public function getContasareceber()
    {
        return $this->hasOne(Contasareceber::className(), ['idconta' => 'idConta']);
    }
}
