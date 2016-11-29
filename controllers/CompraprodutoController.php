<?php

namespace app\controllers;

use Yii;
use app\models\Compraproduto;
use app\models\CompraprodutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompraprodutoController implements the CRUD actions for Compraproduto model.
 */
class CompraprodutoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Compraproduto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompraprodutoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Compraproduto model.
     * @param integer $idCompra
     * @param integer $idProduto
     * @return mixed
     */
    public function actionView($idCompra, $idProduto)
    {
        return $this->render('view', [
            'model' => $this->findModel($idCompra, $idProduto),
        ]);
    }

    /**
     * Creates a new Compraproduto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Compraproduto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $novoPreco= Yii::$app->request->post()['Compraproduto']['valorCompra'];
            $model->comparaPrecoProduto($novoPreco);

            return $this->redirect(['view', 'idCompra' => $model->idCompra, 'idProduto' => $model->idProduto]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Compraproduto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idCompra
     * @param integer $idProduto
     * @return mixed
     */
    public function actionUpdate($idCompra, $idProduto)
    {
        $model = $this->findModel($idCompra, $idProduto);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idCompra' => $model->idCompra, 'idProduto' => $model->idProduto]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Compraproduto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idCompra
     * @param integer $idProduto
     * @return mixed
     */
    public function actionDelete($idCompra, $idProduto)
    {
        $this->findModel($idCompra, $idProduto)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Compraproduto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idCompra
     * @param integer $idProduto
     * @return Compraproduto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idCompra, $idProduto)
    {
        if (($model = Compraproduto::findOne(['idCompra' => $idCompra, 'idProduto' => $idProduto])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
