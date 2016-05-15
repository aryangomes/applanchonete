<?php

namespace app\controllers;

use Yii;
use app\models\Itempedido;
use app\models\Insumos;
use app\models\Produto;
use app\models\Pedido;
use app\models\ItempedidoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\components\AccessFilter;
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
        'autorizacao'=>[
        'class'=>AccessFilter::className(),
        'actions'=>[

        'itempedido'=>[
        'index-itempedido',
        'update-itempedido',
        'delete-itempedido',
        'view-itempedido',
        'create-itempedido',

        ],

        'index'=>'index-itempedido',
        'update'=>'update-itempedido',
        'delete'=>'delete-itempedido',
        'view'=>'view-itempedido',
        'create'=>'create-itempedido',

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
     $produtosvenda = ArrayHelper::map(
        Produto::find()->where(['isInsumo'=>0])->all(), 
        'idProduto','nome');
     $pedidos = ArrayHelper::map(
        Pedido::find()->all(), 
        'idPedido','idPedido');
     $model = new Itempedido();

     if ($model->load(Yii::$app->request->post())) {
       $itempedido = (Yii::$app->request->post()['Itempedido']);
       $produtoVenda = Produto::find()->where(['idProduto'=>  $itempedido['idProduto']])->one();
       $model->total = $produtoVenda->valorVenda * $itempedido['quantidade'];
       $model->save();

       Insumos::atualizaQtdNoEstoqueInsert(
        $itempedido['idProduto'],$itempedido['quantidade']);
       return $this->redirect(['view', 'idPedido' => $model->idPedido, 'idProduto' => $model->idProduto]);
   } else {
    return $this->render('create', [
        'model' => $model,
        'produtosvenda'=>$produtosvenda,
        'pedidos'=>$pedidos,
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
        $oldQtdProdutoVenda = $model->quantidade;

        $pedidos = ArrayHelper::map(
            Pedido::find()->all(), 
            'idPedido','idPedido');

        $produtosvenda = ArrayHelper::map(
            Produto::find()->where(['isInsumo'=>0])->all(), 
            'idProduto','nome');

        if ($model->load(Yii::$app->request->post())) {
           $itempedido = (Yii::$app->request->post()['Itempedido']);
           $produtoVenda = Produto::find()->where(['idProduto'=>  $itempedido['idProduto']])->one();
           $model->total = $produtoVenda->valorVenda * $itempedido['quantidade'];
           $model->save();


           $itempedido = (Yii::$app->request->post()['Itempedido']);
           Insumos::atualizaQtdNoEstoqueUpdate(
            $itempedido['idProduto'],$oldIdProduto,$itempedido['quantidade'],$oldQtdProdutoVenda );
           return $this->redirect(['view', 'idPedido' => $model->idPedido, 'idProduto' => $model->idProduto]);
       } else {
        return $this->render('update', [
            'model' => $model,
            'produtosvenda'=>$produtosvenda,
            'pedidos'=>$pedidos,
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
      $model = $this->findModel($idPedido, $idProduto);

      Insumos::atualizaQtdNoEstoqueDelete($idProduto, $model->quantidade);

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
