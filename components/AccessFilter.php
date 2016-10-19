<?php

namespace app\components;

use Yii;
use yii\base\ActionFilter;
use app\controllers\SiteController;
use yii\web\HttpException;

class AccessFilter extends ActionFilter
{
    public $actions;

    public function beforeAction($action)
    {
        //echo $action->id;
        if (isset($this->actions[$action->id])) {
            //se o Usuário NÃO tiver acesso
            if (!\Yii::$app->user->can($this->actions[$action->id])) {
                //
                if (\Yii::$app->user->isGuest) {
                    return SiteController::redirect('@web/user/login');
                } else {
                    throw new HttpException(403, 'Acesso negado.');
                }

            }
        } else {
            throw new HttpException(403, 'Acesso negado.');
        }
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {

        return parent::afterAction($action, $result);
    }
}


?>