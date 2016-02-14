<?php

namespace amnah\yii2\user\controllers;

use Yii;
use amnah\yii2\user\models\User;
use amnah\yii2\user\models\UserToken;
use amnah\yii2\user\models\UserAuth;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AuthItem;
use yii\helpers\ArrayHelper;
/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller
{
    /**
     * @var \amnah\yii2\user\Module
     * @inheritdoc
     */
    public $module;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        // check for admin permission (`tbl_role.can_admin`)
        // note: check for Yii::$app->user first because it doesn't exist in console commands (throws exception)
        if (!empty(Yii::$app->user) && !Yii::$app->user->can("admin") && !Yii::$app->user->can("user")) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'delete' => ['post'],
        ],
        ],
        ];
    }

    /**
     * List all User models
     * @return mixed
     */
    public function actionIndex()
    {
        /** @var \amnah\yii2\user\models\search\UserSearch $searchModel */
        $searchModel = $this->module->model("UserSearch");
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    /**
     * Display a single User model
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can("view-user") ||
            Yii::$app->user->can("user")) {
            return $this->render('view', [
                'user' => $this->findModel($id),
                ]);
    }else{
        throw new ForbiddenHttpException("Acesso negado!");
    }
}
    /**
     * Create a new User model. If creation is successful, the browser will
     * be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       /** @var \amnah\yii2\user\models\User $user */
       /** @var \amnah\yii2\user\models\Profile $profile */
       /** @var \amnah\yii2\user\models\Role $role */


        // AuthAssigment
       $AuthItem = new AuthItem();
       $permissoes = ArrayHelper::map(
        AuthItem::find()->
        where("name <> 'admin' " )->orderBy('type ASC')->all(), 
        'name','description');
       $permissoesUser = null;
        // set up new user/profile objects
       $user = $this->module->model("User", ["scenario" => "register"]);
       $profile = $this->module->model("Profile");

        // load post data
       $post = Yii::$app->request->post();

       if ($user->load($post)) {

            // ensure profile data gets loaded
           $profile->load($post);

            // validate for ajax request
           if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user, $profile);
        }
        if (isset($post['roles'])) {
           // var_dump($post['User']['role_id']);
            $roles = $post['roles'];

        }


            // validate for normal request
        if ($user->validate() && $profile->validate()) {

            // perform registration
            $role = $this->module->model("Role");
        // VEJA AQUI !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $user->setRegisterAttributes($role::ROLE_USER, $user::STATUS_ACTIVE)->save();

       // $user->setPermissoes(1,$user->id);
            $profile->setUser($user->id)->save();

            $idUser = $user->id;
           // var_dump($idUser);
            foreach ( $roles as $role) {

              $user->setPermissoes($role,$idUser);
          }
          return $this->redirect(['view', 'id' => $user->id]);
      }
  }


  return $this->render("create", compact("user", "profile","permissoes","permissoesUser"));
}

    /**
     * Update an existing User model. If update is successful, the browser
     * will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can("update-user") ||
            Yii::$app->user->can("user")) {
            $authitem = new AuthItem();
        $permissoes = ArrayHelper::map(
            AuthItem::find()->orderBy('type ASC')->all(), 
            'name','description');

        $permissoesUser = ArrayHelper::map(
            AuthItem::find()->innerJoin('auth_assignment',
                'item_name = name')->where(['user_id'=>$id])->all(), 
            'name','description');
        // set up user and profile
        $user = $this->findModel($id);
        $user->setScenario("admin");
        $profile = $user->profile;

        // load post data and validate
        $post = Yii::$app->request->post();
        if ($user->load($post) && $user->validate() && $profile->load($post) && $profile->validate()) {
            if (isset($post['roles'])) {
               // var_dump($post['roles']);
                $roles = $post['roles'];
            }

            Yii::$app->db->createCommand(
                "DELETE from auth_assignment WHERE 
                user_id = :iduser ", [

                ':iduser'=> $user->id,
                ])->execute();
            foreach ( $roles as $role) {

                $user->alterarPermissoes($role,$user->id);
            }

            $user->save(false);
            $profile->setUser($user->id)->save(false);
            return $this->redirect(['view', 'id' => $user->id]);
        }

        // render
        return $this->render('update', compact('user', 'profile','permissoes','permissoesUser'));
    } else{
        throw new ForbiddenHttpException("Acesso negado!");
    }
}

    /**
     * Delete an existing User model. If deletion is successful, the browser
     * will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can("delete-user") ||
            Yii::$app->user->can("user")) {
        // delete profile and userTokens first to handle foreign key constraint
            $user = $this->findModel($id);
        $profile = $user->profile;
        UserToken::deleteAll(['user_id' => $user->id]);
        UserAuth::deleteAll(['user_id' => $user->id]);
        $profile->delete();
        $user->delete();

        return $this->redirect(['index']);
    } else{
        throw new ForbiddenHttpException("Acesso negado!");
    }
}

    /**
     * Find the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var \amnah\yii2\user\models\User $user */
        $user = $this->module->model("User");
        $user = $user::findOne($id);
        if ($user) {
            return $user;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
