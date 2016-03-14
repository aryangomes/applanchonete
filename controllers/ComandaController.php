<?php

namespace app\controllers;

use Yii;
use app\models\Comanda;
use app\models\ComandaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
/**
 * ComandaController implements the CRUD actions for Comanda model.
 */
class ComandaController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
        'roles' => ['comanda','index-comanda'],
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
     * Lists all Comanda models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can("index-comanda") ||
        Yii::$app->user->can("comanda") ) {
        
        $searchModel = new ComandaSearch();
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
     * Displays a single Comanda model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can("view-comanda") ||
            Yii::$app->user->can("comanda") ) {
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Creates a new Comanda model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-comanda") ||
            Yii::$app->user->can("comanda") ) {
        
        $model = new Comanda();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idComanda]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        } else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Updates an existing Comanda model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can("update-comanda") ||
        Yii::$app->user->can("comanda") ) {
        
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idComanda]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        } else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Deletes an existing Comanda model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can("delete-comanda") ||
        Yii::$app->user->can("comanda") ) {
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
        } else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Finds the Comanda model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comanda the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comanda::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
