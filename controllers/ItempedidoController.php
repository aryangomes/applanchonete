<?php

namespace app\controllers;

use Yii;
use app\models\Itempedido;
use app\models\Insumos;
use app\models\ItempedidoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItempedidoController implements the CRUD actions for Itempedido model.
 */
class ItempedidoController extends Controller
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
     * Lists all Itempedido models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItempedidoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single Itempedido model.
     * @param integer $idPedido
     * @param integer $idProduto
     * @return mixed
     */
    public function actionView($idPedido, $idProduto)
    {
        return $this->render('view', [
            'model' => $this->findModel($idPedido, $idProduto),
            ]);
    }

    /**
     * Creates a new Itempedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Itempedido();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $itempedido = (Yii::$app->request->post()['Itempedido']);
            Insumos::atualizaQtdNoEstoque(
                $itempedido['idProduto'],$itempedido['quantidade']);
            return $this->redirect(['view', 'idPedido' => $model->idPedido, 'idProduto' => $model->idProduto]);
        } else {
            return $this->render('create', [
                'model' => $model,
                ]);
        }
    }

    /**
     * Updates an existing Itempedido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idPedido
     * @param integer $idProduto
     * @return mixed
     */
    public function actionUpdate($idPedido, $idProduto)
    {
        $model = $this->findModel($idPedido, $idProduto);
        $oldIdProduto = $idProduto;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          
           $itempedido = (Yii::$app->request->post()['Itempedido']);
           Insumos::atualizaQtdNoEstoqueUpdate(
            $itempedido['idProduto'],$oldIdProduto,$itempedido['quantidade']);
           return $this->redirect(['view', 'idPedido' => $model->idPedido, 'idProduto' => $model->idProduto]);
       } else {
        return $this->render('update', [
            'model' => $model,

            ]);
    }
}

    /**
     * Deletes an existing Itempedido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idPedido
     * @param integer $idProduto
     * @return mixed
     */
    public function actionDelete($idPedido, $idProduto)
    {
        $this->findModel($idPedido, $idProduto)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Itempedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idPedido
     * @param integer $idProduto
     * @return Itempedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idPedido, $idProduto)
    {
        if (($model = Itempedido::findOne(['idPedido' => $idPedido, 'idProduto' => $idProduto])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
