<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pagamento".
 *
 * @property integer $idConta
 * @property integer $idPedido
 * @property integer $formapagamento_idTipoPagamento
 *
 * @property Formapagamento $formapagamentoIdTipoPagamento
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
            [['idConta', 'idPedido', 'formapagamento_idTipoPagamento'], 'required'],
            [['idConta', 'idPedido', 'formapagamento_idTipoPagamento'], 'integer'],
            [['formapagamento_idTipoPagamento'], 'exist', 'skipOnError' => true, 'targetClass' => Formapagamento::className(), 'targetAttribute' => ['formapagamento_idTipoPagamento' => 'idTipoPagamento']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idConta' => Yii::t('app', 'Conta'),
            'idPedido' => Yii::t('app', 'Pedido'),
            'formapagamento_idTipoPagamento' => Yii::t('app', 'Forma de Pagamento'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormapagamentoIdTipoPagamento()
    {
        return $this->hasOne(Formapagamento::className(), ['idTipoPagamento' => 'formapagamento_idTipoPagamento']);
    }
    
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getContasareceber() {
        return $this->hasOne(Contasareceber::className(), ['idconta' => 'idConta']);
    }
}
