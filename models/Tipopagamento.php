<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipopagamento".
 *
 * @property integer $idTipoPagamento
 * @property string $titulo
 * @property string $descricao
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
        [['titulo'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'idTipoPagamento' => Yii::t('app', 'Tipo Pagamento'),
        'titulo' => Yii::t('app', 'Titulo'),
        'descricao' => Yii::t('app', 'Descricao'),
        ];
    }
}
