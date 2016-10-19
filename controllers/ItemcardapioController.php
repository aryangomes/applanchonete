<?php

namespace app\controllers;

use Yii;
use app\models\Itemcardapio;
use app\models\ItemcardapioSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/*use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;*/
use app\components\AccessFilter;

/**
 * ItemcardapioController implements the CRUD actions for Itemcardapio model.
 */
class ItemcardapioController extends Controller
{
    public function behaviors()
    {
        return [
//            'access' => [
//        'class' => AccessControl::classname(),
//        'only'=> ['create','update','view','delete','index'],
//        'rules'=> [
//        ['allow'=>true,
//        'rules' => ['itemcardapio','index-itemcardapio'],


                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['post'],
                    ],
                ],
//            ],
            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'itemcardapio' => [
                        'index-itemcardapio',
                        'update-itemcardapio',
                        'delete-itemcardapio',
                        'view-itemcardapio',
                        'create-itemcardapio',
                    ],

                    'index' => 'index-itemcardapio',
                    'update' => 'update-itemcardapio',
                    'delete' => 'delete-itemcardapio',
                    'view' => 'view-itemcardapio',
                    'create' => 'create-itemcardapio',
                ],
            ],
        ];
    }

    /**
     * Lists all Itemcardapio models.
     * @return mixed
     */
    public function actionIndex()
    {


            $searchModel = new ItemcardapioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

    }

    /**
     * Displays a single Itemcardapio model.
     * @param integer $idCardapio
     * @param integer $idProduto
     * @return mixed
     */
    public function actionView($idCardapio, $idProduto)
    {
        if (Yii::$app->user->can("view-itemcardapio") ||
            Yii::$app->user->can("itemcardapio")
        ) {

            return $this->render('view', [
                'model' => $this->findModel($idCardapio, $idProduto),
            ]);
        } else {
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Creates a new Itemcardapio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-itemcardapio") ||
            Yii::$app->user->can("itemcardapio")
        ) {

            $model = new Itemcardapio();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idCardapio' => $model->idCardapio, 'idProduto' => $model->idProduto]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Updates an existing Itemcardapio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idCardapio
     * @param integer $idProduto
     * @return mixed
     */
    public function actionUpdate($idCardapio, $idProduto)
    {
        if (Yii::$app->user->can("update-itemcardapio") ||
            Yii::$app->user->can("itemcardapio")
        ) {

            $model = $this->findModel($idCardapio, $idProduto);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idCardapio' => $model->idCardapio, 'idProduto' => $model->idProduto]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Deletes an existing Itemcardapio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idCardapio
     * @param integer $idProduto
     * @return mixed
     */
    public function actionDelete($idCardapio, $idProduto)
    {
        if (Yii::$app->user->can("delete-itemcardapio") ||
            Yii::$app->user->can("itemcardapio")
        ) {

            $this->findModel($idCardapio, $idProduto)->delete();

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Finds the Itemcardapio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idCardapio
     * @param integer $idProduto
     * @return Itemcardapio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idCardapio, $idProduto)
    {
        if (($model = Itemcardapio::findOne(['idCardapio' => $idCardapio, 'idProduto' => $idProduto])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
