<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipopagamento".
 *
 * @property integer $idTipoPagamento
 * @property string $titulo
 * @property string $descricao
 *
 * @property Pagamento[] $pagamentos
 */
class Tipopagamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipopagamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['descricao'], 'string'],
            [['titulo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTipoPagamento' => 'Id Tipo Pagamento',
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagamentos()
    {
        return $this->hasMany(Pagamento::className(), ['tipoPagamento_idTipoPagamento' => 'idTipoPagamento']);
    }
}
