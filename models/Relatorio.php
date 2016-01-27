<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "relatorio".
 *
 * @property integer $idrelatorio
 * @property string $nome
 * @property string $datageracao
 * @property string $tipo
 * @property string $inicio_intervalo
 * @property string $fim_intervalo
 * @property integer $usuario_id
 *
 * @property Usuario $usuario
 */
class Relatorio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relatorio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'datageracao', 'fim_intervalo', 'usuario_id'], 'required'],
            [['datageracao', 'inicio_intervalo', 'fim_intervalo'], 'safe'],
            [['usuario_id'], 'integer'],
            [['nome'], 'string', 'max' => 100],
            [['tipo'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idrelatorio' => Yii::t('app', 'Idrelatorio'),
            'nome' => Yii::t('app', 'Nome'),
            'datageracao' => Yii::t('app', 'Datageracao'),
            'tipo' => Yii::t('app', 'Tipo'),
            'inicio_intervalo' => Yii::t('app', 'Inicio Intervalo'),
            'fim_intervalo' => Yii::t('app', 'Fim Intervalo'),
            'usuario_id' => Yii::t('app', 'Usuario ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
}