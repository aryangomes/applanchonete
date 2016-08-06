<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "formapagamento".
 *
 * @property integer $idTipoPagamento
 * @property string $titulo
 * @property string $descricao
 */
class Formapagamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'formapagamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['descricao'], 'string'],
            [['titulo'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idTipoPagamento' => Yii::t('app', 'Id Tipo de Pagamento'),
            'titulo' => Yii::t('app', 'Tipo de Pagamento'),
            'descricao' => Yii::t('app', 'Descrição'),
        ];
    }
}
