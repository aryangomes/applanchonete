<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
        'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout'],
        'rules' => [
        [
        'actions' => ['logout'],
        'allow' => true,
        'roles' => ['@'],
        ],
        ],
        ],
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'logout' => ['post'],
        ],
        ],
        ];
    }

    public function actions()
    {
        return [
        'error' => [
        'class' => 'yii\web\ErrorAction',
        ],
        'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
        ],
        ];
    }

    public function actionIndex()
    {


        //return $this->render('index');
      return $this->actionLogin();
  }

  public function actionLogin()
  {
    if (!\Yii::$app->user->isGuest) {
     if (Yii::$app->user->can("admin")) {
      return $this->redirect(['/user/admin']);
  }
  return $this->render('index');
            //return $this->goHome();
}else{
    $this->redirect('user/login');
}

$model = new LoginForm();
if ($model->load(Yii::$app->request->post()) && $model->login()) {
    return $this->goBack();
}

$this->layout = 'main';
return $this->render('login', [
    'model' => $model,
    ]);
}

public function actionLogout()
{
    Yii::$app->user->logout();

    return $this->goHome();
}

public function actionContact()
{
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
        Yii::$app->session->setFlash('contactFormSubmitted');

        return $this->refresh();
    }
    return $this->render('contact', [
        'model' => $model,
        ]);
}

public function actionAbout()
{
    return $this->render('about');
}
}
