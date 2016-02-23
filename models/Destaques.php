<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "destaques".
 *
 * @property integer $idDestaques
 * @property string $titulo
 * @property string $dataEntrada
 * @property string $dataSaida
 * @property string $link
 * @property integer $status
 */
class Destaques extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'destaques';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idDestaques', 'titulo', 'dataEntrada', 'dataSaida', 'link'], 'required'],
            [['idDestaques', 'status'], 'integer'],
            [['dataEntrada', 'dataSaida'], 'safe'],
            [['titulo'], 'string', 'max' => 45],
            [['link'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idDestaques' => 'Id Destaques',
            'titulo' => 'Titulo',
            'dataEntrada' => 'Data Entrada',
            'dataSaida' => 'Data Saida',
            'link' => 'Link',
            'status' => 'Status',
        ];
    }
}
