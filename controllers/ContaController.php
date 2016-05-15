<?php

namespace app\controllers;

use Yii;
use app\models\Conta;
use app\models\ContaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Contasapagar;
use app\models\Contasareceber;
use app\components\AccessFilter;
use app\models\Itempedido;
use app\models\Pagamento;
use app\models\Insumos;
/**
 * ContaController implements the CRUD actions for Conta model.
 */
class ContaController extends Controller
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
        
        'conta'=>[
        'index-conta',
        'update-conta',
        'delete-conta',
        'view-conta',
        'create-conta',
        ],
        
        'index'=>'index-conta',
        'update'=>'update-conta',
        'delete'=>'delete-conta',
        'view'=>'view-conta',
        'create'=>'create-conta',
        ],
        ],
        ];
    }

    /**
     * Lists all Conta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single Conta model.
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
     * Creates a new Conta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Conta();
        $modelContaapagar = new Contasapagar();
        $modelContasareceber = new Contasareceber();
        $tiposConta =['Pagamento'=>'Pagamento','Compra'=>'Compra'];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {


            $conta = Yii::$app->request->post()['Conta'];

            $contasapagar = Yii::$app->request->post()['Contasapagar'];
            $contasareceber = Yii::$app->request->post()['Contasareceber'];
            if ($conta['tipoConta'] == 'contasapagar' ) {
                $modelContaapagar->idconta = $model->idconta;
                $modelContaapagar->situacaoPagamento = $contasapagar['situacaoPagamento'];
                $modelContaapagar->dataVencimento = $contasapagar['dataVencimento'];
                $modelContaapagar->save();
            }else if ($conta['tipoConta'] == 'contasareceber') {
              $modelContasareceber->idconta = $model->idconta;
              if (($contasareceber['dataHora']) != null) {
               $modelContasareceber->dataHora = $contasareceber['dataHora'];
           }

           $modelContasareceber->save();
       }

       return $this->redirect(['view', 'id' => $model->idconta]);
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idconta]);*/
        } else {
            return $this->render('create', [
                'model' => $model,
                'tiposConta'=>$tiposConta,
                'modelContaapagar'=>$modelContaapagar,
                'modelContasareceber'=>$modelContasareceber,
                ]);
        }
    }

    /**
     * Updates an existing Conta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tiposConta =['Pagamento'=>'Pagamento','Compra'=>'Compra'];
        $modelContaapagar = new Contasapagar();
        $modelContasareceber = new Contasareceber();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idconta]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tiposConta'=>$tiposConta,
                'modelContaapagar'=>$modelContaapagar,
                'modelContasareceber'=>$modelContasareceber,
                ]);
        }
    }

    /**
     * Deletes an existing Conta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
     $idpedido = Pagamento::find()->where(['idconta'=>$id])->one();
     if (isset($idpedido)) {
         $itenspedido = Itempedido::find()->where(['idPedido'=>$idpedido->idPedido])->all();

         foreach ($itenspedido as  $p) {
           Insumos::atualizaQtdNoEstoqueDelete($p->idProduto,$p->quantidade);
       }

   }
   $this->findModel($id)->delete();

   return $this->redirect(['index']);
}

    /**
     * Finds the Conta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Conta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
