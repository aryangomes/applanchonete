<?php

namespace app\controllers;

use Yii;
use app\models\Contasareceber;
use app\models\ContasareceberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Conta;
use yii\helpers\ArrayHelper;
use app\components\AccessFilter;

/**
 * ContasareceberController implements the CRUD actions for Contasareceber model.
 */
class ContasareceberController extends Controller
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

                    'contasareceber' => [
                        'index-contasareceber',
                        'update-contasareceber',
                        'delete-contasareceber',
                        'view-contasareceber',
                        'create-contasareceber',
                    ],

                    'index' => 'index-contasareceber',
                    'update' => 'update-contasareceber',
                    'delete' => 'delete-contasareceber',
                    'view' => 'view-contasareceber',
                    'create' => 'create-contasareceber',
                ],
            ],
        ];
    }

    /**
     * Lists all Contasareceber models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContasareceberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contasareceber model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelContasareceber' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Contasareceber model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new Contasareceber();
        $contas = ArrayHelper::map(
            Conta::find()->where('idconta not in (select idconta from contasareceber) && 
                idconta not in (select idconta from contasapagar)')->all(),
            'idconta','descricao'
            );
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idconta]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'contas'=>$contas,
                ]);
        }
    }*/

    /**
     * Updates an existing Contasareceber model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelContasareceber = $this->findModel($id);
        $contas = ArrayHelper::map(
            Conta::find()->where('idconta not in (select idconta from contasareceber) && 
                idconta not in (select idconta from contasapagar)')->all(),
            'idconta', 'descricao'
        );
        if ($modelContasareceber->load(Yii::$app->request->post()) && $modelContasareceber->save()) {
            return $this->redirect(['view', 'id' => $modelContasareceber->idconta]);
        } else {
            return $this->render('update', [
                'modelContasareceber' => $modelContasareceber,
                'contas' => $contas,
            ]);
        }
    }

    /**
     * Deletes an existing Contasareceber model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //Guarda a mensagem
        $mensagem = "";

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($this->findModel($id)->delete()) {
                $transaction->commit();
            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
            $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
        }

        $searchModel = new ContasareceberSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mensagem' => $mensagem

        ]);
    }

    /**
     * Finds the Contasareceber model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contasareceber the loaded modelContasareceber
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelContasareceber = Contasareceber::findOne($id)) !== null) {
            return $modelContasareceber;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
