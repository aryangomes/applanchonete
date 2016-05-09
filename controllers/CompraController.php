<?php

namespace app\controllers;

use Yii;
use app\models\Compra;
use app\models\CompraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Conta;
use app\models\Compraproduto;
use app\models\Produto;
use yii\helpers\ArrayHelper;
/**
 * CompraController implements the CRUD actions for Compra model.
 */
class CompraController extends Controller
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
     * Lists all Compra models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Compra model.
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
     * Creates a new Compra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Compra();
        $conta = new Conta();
        $compraProduto = new Compraproduto();
        $produtos = ArrayHelper::map(Produto::find()->all(),
            'idProduto','nome');
        if ((Yii::$app->request->post()) ) {
           
            $conta->tipoConta = 'contasapagar';
           
            if ( $conta->save()) {
                $model->idconta = $conta->idconta;
            $model->dataCompra = Yii::$app->request->post()['Compra']['dataCompra'];
             $model->save();

            $compraprodutos = Yii::$app->request->post()['Compraproduto'];
            $valorescompraprodutos = Yii::$app->request->post()['compraproduto-valorcompra-disp'];

          for ($i=0; $i < count($compraprodutos['idProduto']); $i++) {
            $cp = new Compraproduto();
          $cp->idCompra =  $model->idconta;
          $cp->idProduto= $compraprodutos['idProduto'][$i];
          $cp->quantidade= $compraprodutos['quantidade'][$i]; 

          if($i <= 0) {
                 $cp->valorCompra= $compraprodutos['valorCompra'][0]; 
             }else{
                $cp->valorCompra=( substr($valorescompraprodutos[$i-1], 4));
             }
        
        
             $cp->save();
          }

            return $this->redirect(['view', 'id' => $model->idconta]);
            }
          
        } else {
            return $this->render('create', [
                'model' => $model,
                'compraProduto'=>$compraProduto,
                'produtos'=>$produtos,
            ]);
        }
    }

    /**
     * Updates an existing Compra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idconta]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Compra model.
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
     * Finds the Compra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Compra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compra::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
