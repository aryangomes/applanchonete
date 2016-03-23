<?php

namespace app\controllers;

use Yii;
use app\models\Destaques;
use app\models\DestaquesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\components\AccessFilter;

/**
 * DestaquesController implements the CRUD actions for Destaques model.
 */
class DestaquesController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
//        'class' => AccessControl::classname(),
//        'only'=> ['create','update','view','delete','index'],
//        'rules'=> [
//        ['allow'=>true,
//        'roles' => ['destaques','index-destaques'],
//        ],
//        ]
//        ],
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'delete' => ['post'],
        ],
        ],
        ],
        'autorizacao'=>[
           'class'=>AccessFilter::className(),
           'actions'=>[
    
           'destaques'=>[
               'index-destaques',
               'update-destaques',
               'delete-destaques',
               'view-destaques',
               'create-destaques',
           ],
    
            'index'=>'index-destaques',
            'update'=>'update-destaques',
            'delete'=>'delete-destaques',
            'view'=>'view-destaques',
            'create'=>'create-destaques',
            ],
            ],
         ];    
    }

    /**
     * Lists all Destaques models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can("index-destaques") ||
        Yii::$app->user->can("destaques") ) {
        
        $searchModel = new DestaquesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Displays a single Destaques model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can("view-destaques") ||
        Yii::$app->user->can("destaques") ) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Creates a new Destaques model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-destaques") ||
        Yii::$app->user->can("destaques") ) {
        
        $model = new Destaques();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idDestaques]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Updates an existing Destaques model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can("update-destaques") ||
        Yii::$app->user->can("destaques") ) {
        
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idDestaques]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Deletes an existing Destaques model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can("delete-destaques") ||
        Yii::$app->user->can("destaques") ) {
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Finds the Destaques model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Destaques the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Destaques::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
