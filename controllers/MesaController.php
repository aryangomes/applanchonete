<?php

namespace app\controllers;

use Yii;
use app\models\Mesa;
use app\models\MesaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MesaController implements the CRUD actions for Mesa model.
 */
class MesaController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
        'roles' => ['mesa','index-mesa'],
        ],
        ]
        ],
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'delete' => ['post'],
        ],
        ],
        ];
    }

    /**
     * Lists all Mesa models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can("index-mesa") ||
        Yii::$app->user->can("mesa") ) {

        $searchModel = new MesaSearch();
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
     * Displays a single Mesa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can("view-mesa") ||
        Yii::$app->user->can("mesa") ) {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Creates a new Mesa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-mesa") ||
        Yii::$app->user->can("mesa") ) {

        $model = new Mesa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idMesa]);
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
     * Updates an existing Mesa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can("update-mesa") ||
        Yii::$app->user->can("mesa") ) {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idMesa]);
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
     * Deletes an existing Mesa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can("delete-mesa") ||
        Yii::$app->user->can("mesa") ) {

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Finds the Mesa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mesa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mesa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
