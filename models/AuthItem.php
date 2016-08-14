<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 */
class AuthItem extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Description'),
            'rule_name' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments() {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName() {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren() {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0() {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }

    public function getDescription($role_id) {
        return $this->find('description')->where(['type' => $role_id])->one();
    }

    public function getDescriptionByName($name) {
        return $this->find()->where(['name' => $name])->one();
    }

    public function getPermissao($role_id) {
        return AuthItem::find()->where(['type' => $role_id])->one();
    }

    /**
     * @return array|null
     * Gera a lista de Permissões com optgroups
     */
    public static function getListToDropDownList() {
        $options = [];
        $auxOptions = [];
        $optGroups = AuthItem::find()
                        ->where("name not like '%-%' and name <> 'admin' and name <> 'alterarprodutovenda'  
            and name <> 'produtosvenda'   and name <> 'cadastrarprodutovenda'
            and name <> 'avaliacaoproduto'
            and name <> 'listadeinsumos'
            and name <> 'listadeprodutosporinsumo'
            and name <>'definirvalorprodutovenda'")->orderBy('type ASC')->all();

        foreach ($optGroups as $macroPermissao) {

            $permissao = [];
            $auxPermissoes = AuthItem::find()->
                            where("name <> 'admin' and name like '%" . $macroPermissao->name . "%'")->orderBy('type ASC')->all();
            foreach ($auxPermissoes as $p) {
                $key = $p->name;
                $permissao[$key] = $p->description;
            }
            $options[$macroPermissao->name] = $permissao;
        }

        return $options;
    }

}
