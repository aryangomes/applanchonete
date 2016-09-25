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
            [[ 'inicio_intervalo','datageracao', 'fim_intervalo', 'usuario_id'], 'required'],
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
            'nome' => Yii::t('app', 'Título'),
            'datageracao' => Yii::t('app', 'Data de geração'),
            'tipo' => Yii::t('app', 'Tipo'),
            'inicio_intervalo' => Yii::t('app', 'Inicio do intervalo'),
            'fim_intervalo' => Yii::t('app', 'Fim do intervalo'),
            'usuario_id' => Yii::t('app', 'Usuário'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
    
    /**
     * 
     * @param type $data
     * Formata a data para o formato dia/mes/ano
     */
    public static function formatarDataDiaMesAno($data) {
        $dataFormatada = null;
        if($data !=null){
            $dataFormatada = date('d/m/Y',  strtotime($data));
        }
        
        return $dataFormatada;
    }
}
