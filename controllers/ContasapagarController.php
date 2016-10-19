<?php

namespace app\controllers;

use Yii;
use app\models\Contasapagar;
use app\models\ContasapagarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Conta;
use yii\helpers\ArrayHelper;
use app\components\AccessFilter;

/**
 * ContasapagarController implements the CRUD actions for Contasapagar model.
 */
class ContasapagarController extends Controller
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

                    'contasapagar' => [
                        'index-contasapagar',
                        'update-contasapagar',
                        'delete-contasapagar',
                        'view-contasapagar',
                        'create-contasapagar',
                    ],


                    'index' => 'index-contasapagar',
                    'update' => 'update-contasapagar',
                    'delete' => 'delete-contasapagar',
                    'view' => 'view-contasapagar',
                    'create' => 'create-contasapagar',

                ],
            ],
        ];
    }

    /**
     * Lists all Contasapagar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContasapagarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contasapagar model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelContasapagar' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Contasapagar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /* public function actionCreate()
     {
         $model = new Contasapagar();
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
     * Updates an existing Contasapagar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelContasapagar = $this->findModel($id);
        $contas = ArrayHelper::map(
            Conta::find()->where('idconta not in (select idconta from contasareceber) && 
                idconta not in (select idconta from contasapagar)')->all(),
            'idconta', 'descricao'
        );
        if ($modelContasapagar->load(Yii::$app->request->post()) && $modelContasapagar->save()) {
            return $this->redirect(['view', 'id' => $modelContasapagar->idconta]);
        } else {
            return $this->render('update', [
                'modelContasapagar' => $modelContasapagar,
                'contas' => $contas,
            ]);
        }
    }

    /**
     * Deletes an existing Contasapagar model.
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
     * Finds the Contasapagar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contasapagar the loaded modelContasapagar
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelContasapagar = Contasapagar::findOne($id)) !== null) {
            return $modelContasapagar;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
