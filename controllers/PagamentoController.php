<?php

namespace app\controllers;

use app\components\AccessFilter;
use Yii;
use app\models\Pagamento;
use app\models\PagamentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PagamentoController implements the CRUD actions for Pagamento model.
 */
class PagamentoController extends Controller
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
            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'pagamento' => [
                        'index-pagamento',
                        'update-pagamento',
                        'delete-pagamento',
                        'view-pagamento',
                        'create-pagamento',
                    ],

                    'index' => 'index-pagamento',
                    'update' => 'update-pagamento',
                    'delete' => 'delete-pagamento',
                    'view' => 'view-pagamento',
                    'create' => 'create-pagamento',
                ],
            ],
        ];
    }

    /**
     * Lists all Pagamento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PagamentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pagamento model.
     * @param integer $idConta
     * @param integer $idPedido
     * @return mixed
     */
    public function actionView($idConta, $idPedido)
    {
        return $this->render('view', [
            'modelPagamento' => $this->findModel($idConta, $idPedido),
        ]);
    }

    /**
     * Creates a new Pagamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelPagamento = new Pagamento();

        if ($modelPagamento->load(Yii::$app->request->post()) && $modelPagamento->save()) {
            return $this->redirect(['view', 'idConta' => $modelPagamento->idConta, 'idPedido' => $modelPagamento->idPedido]);
        } else {
            return $this->render('create', [
                'modelPagamento' => $modelPagamento,
            ]);
        }
    }

    /**
     * Updates an existing Pagamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idConta
     * @param integer $idPedido
     * @return mixed
     */
    public function actionUpdate($idConta, $idPedido)
    {
        $modelPagamento = $this->findModel($idConta, $idPedido);

        if ($modelPagamento->load(Yii::$app->request->post()) && $modelPagamento->save()) {
            return $this->redirect(['view', 'idConta' => $modelPagamento->idConta, 'idPedido' => $modelPagamento->idPedido]);
        } else {
            return $this->render('update', [
                'modelPagamento' => $modelPagamento,
            ]);
        }
    }

    /**
     * Deletes an existing Pagamento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idConta
     * @param integer $idPedido
     * @return mixed
     */
    public function actionDelete($idConta, $idPedido)
    {

        //Guarda a mensagem
        $mensagem = "";

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($this->findModel($idConta, $idPedido)->delete()) {
                $transaction->commit();
            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
            $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
        }

        $searchModel = new PagamentoSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mensagem' => $mensagem

        ]);
    }

    /**
     * Finds the Pagamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idConta
     * @param integer $idPedido
     * @return Pagamento the loaded modelPagamento
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idConta, $idPedido)
    {
        if (($modelPagamento = Pagamento::findOne(['idConta' => $idConta, 'idPedido' => $idPedido])) !== null) {
            return $modelPagamento;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
