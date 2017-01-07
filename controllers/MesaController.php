<?php

namespace app\controllers;

use Yii;
use app\models\Mesa;
use app\models\MesaSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/*use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;*/
use app\components\AccessFilter;

/**
 * MesaController implements the CRUD actions for Mesa model.
 */
class MesaController extends Controller
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
            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'mesa' => [
                        'index-mesa',
                        'update-mesa',
                        'delete-mesa',
                        'view-mesa',
                        'create-mesa',
                    ],

                    'index' => 'index-mesa',
                    'update' => 'update-mesa',
                    'delete' => 'delete-mesa',
                    'view' => 'view-mesa',
                    'create' => 'create-mesa',
                ],
            ],
        ];
    }

    /**
     * Lists all Mesa models.
     * @return mixed
     */
    public function actionIndex()
    {


        $searchModel = new MesaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Mesa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {


        return $this->render('view', [
            'modelMesa' => $this->findModel($id),
        ]);

    }

    /**
     * Creates a new Mesa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {


        $modelMesa = new Mesa();

        if ($modelMesa->load(Yii::$app->request->post()) && $modelMesa->save()) {

            return $this->redirect(['view', 'id' => $modelMesa->idMesa]);

        } else {


            return $this->render('create', [
                'modelMesa' => $modelMesa,
            ]);
        }

    }

    /**
     * Updates an existing Mesa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {


        $modelMesa = $this->findModel($id);

        if ($modelMesa->load(Yii::$app->request->post()) && $modelMesa->save()) {
            return $this->redirect(['view', 'id' => $modelMesa->idMesa]);
        } else {
            return $this->render('update', [
                'modelMesa' => $modelMesa,
            ]);
        }

    }

    /**
     * Deletes an existing Mesa model.
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

        $searchModel = new MesaSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mensagem' => $mensagem

        ]);

    }

    /**
     * Finds the Mesa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mesa the loaded modelMesa
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelMesa = Mesa::findOne($id)) !== null) {
            return $modelMesa;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
