<?php

namespace app\controllers;

use Yii;
use app\models\Cardapio;
use app\models\CardapioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
/**
 * CardapioController implements the CRUD actions for Cardapio model.
 */
class CardapioController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
        'roles' => ['cardapio','index-cardapio'],
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
     * Lists all Cardapio models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can("index-cardapio") ||
        Yii::$app->user->can("cardapio") ) {
        $searchModel = new CardapioSearch();
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
     * Displays a single Cardapio model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can("view-cardapio") ||
            Yii::$app->user->can("cardapio") ) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Creates a new Cardapio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-cardapio") ||
            Yii::$app->user->can("cardapio") ) {
        $model = new Cardapio();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idCardapio]);
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
     * Updates an existing Cardapio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can("update-cardapio") ||
        Yii::$app->user->can("cardapio") ) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idCardapio]);
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
     * Deletes an existing Cardapio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can("delete-cardapio") ||
        Yii::$app->user->can("cardapio") ) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
        }else{
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Finds the Cardapio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cardapio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cardapio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
