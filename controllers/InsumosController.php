<?php

namespace app\controllers;

use Yii;
use app\models\Insumos;
use app\models\InsumosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Produto;
/**
 * InsumosController implements the CRUD actions for Insumos model.
 */
class InsumosController extends Controller
{
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
     * Lists all Insumos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InsumosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single Insumos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            ]);
    }

    /**
     * Creates a new Insumos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Insumos();
        $produtosvenda = ArrayHelper::map(
            Produto::find()->where(['isInsumo'=>0])->all(), 
            'idProduto','nome');
        $insumos = ArrayHelper::map(
            Produto::find()->where(['isInsumo'=>1])->all(), 
            'idProduto','nome');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idprodutoVenda]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'insumos' => $insumos,
                'produtosvenda' => $produtosvenda,
                ]);
        }
    }

    /**
     * Updates an existing Insumos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idprodutoVenda]);
        } else {
            return $this->render('update', [
                'model' => $model,
                ]);
        }
    }

    /**
     * Deletes an existing Insumos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Insumos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Insumos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Insumos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
