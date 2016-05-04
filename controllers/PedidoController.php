<?php

namespace app\controllers;

use Yii;
use app\models\Pedido;
use app\models\PedidoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Situacaopedido;
use yii\helpers\ArrayHelper;
use app\components\AccessFilter;
use app\models\Insumos;
use app\models\Itempedido;
/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends Controller
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
        
        'pedido'=>[
        'index-pedido',
        'update-pedido',
        'delete-pedido',
        'view-pedido',
        'create-pedido',
        ],
        
        'index'=>'index-pedido',
        'update'=>'update-pedido',
        'delete'=>'delete-pedido',
        'view'=>'view-pedido',
        'create'=>'create-pedido',
        ],
        ],
        ];
    }

    /**
     * Lists all Pedido models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PedidoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single Pedido model.
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
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pedido();
        $situacaopedido = ArrayHelper::map(
            Situacaopedido::find()->all()
            , 'idSituacaoPedido' ,'titulo');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idPedido]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'situacaopedido'=>$situacaopedido,
                ]);
        }
    }

    /**
     * Updates an existing Pedido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $situacaopedido = ArrayHelper::map(
            Situacaopedido::find()->all()
            , 'idSituacaoPedido' ,'titulo');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idPedido]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'situacaopedido'=>$situacaopedido,
                ]);
        }
    }

    /**
     * Deletes an existing Pedido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

     $itenspedido = Itempedido::find()->where(['idPedido'=>$id])->all();

     foreach ($itenspedido as  $p) {
       Insumos::atualizaQtdNoEstoqueDelete($p->idProduto,$p->quantidade);
   }
   $this->findModel($id)->delete();

   return $this->redirect(['index']);
}

    /**
     * Finds the Pedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pedido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
