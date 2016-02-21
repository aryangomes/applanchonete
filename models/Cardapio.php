<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cardapio".
 *
 * @property integer $idCardapio
 * @property string $data
 * @property string $titulo
 *
 * @property Itemcardapio[] $itemcardapios
 * @property Produto[] $idProdutos
 */
class Cardapio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cardapio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data', 'titulo'], 'required'],
            [['data'], 'safe'],
            [['titulo'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idCardapio' => 'Id Cardapio',
            'data' => 'Data',
            'titulo' => 'Titulo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemcardapios()
    {
        return $this->hasMany(Itemcardapio::className(), ['idCardapio' => 'idCardapio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProdutos()
    {
        return $this->hasMany(Produto::className(), ['idProduto' => 'idProduto'])->viaTable('itemcardapio', ['idCardapio' => 'idCardapio']);
    }
}
