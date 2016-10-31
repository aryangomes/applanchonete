<?php

namespace app\controllers;

use app\components\AccessFilter;
use Yii;
use app\models\Tipocustofixo;
use app\models\TipocustofixoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipocustofixoController implements the CRUD actions for Tipocustofixo model.
 */
class TipocustofixoController extends Controller
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

                    'tipocustofixo' => [
                        'index-tipocustofixo',
                        'update-tipocustofixo',
                        'delete-tipocustofixo',
                        'view-tipocustofixo',
                        'create-tipocustofixo',
                    ],

                    'index' => 'index-tipocustofixo',
                    'update' => 'update-tipocustofixo',
                    'delete' => 'delete-tipocustofixo',
                    'view' => 'view-tipocustofixo',
                    'create' => 'create-tipocustofixo',
                ],
            ],
        ];
    }

    /**
     * Lists all Tipocustofixo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TipocustofixoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tipocustofixo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelTipocustofixo' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tipocustofixo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelTipocustofixo = new Tipocustofixo();

        if ($modelTipocustofixo->load(Yii::$app->request->post()) && $modelTipocustofixo->save()) {
            return $this->redirect(['view', 'id' => $modelTipocustofixo->idtipocustofixo]);
        } else {
            return $this->render('create', [
                'modelTipocustofixo' => $modelTipocustofixo,
            ]);
        }
    }

    /**
     * Updates an existing Tipocustofixo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelTipocustofixo = $this->findModel($id);

        if ($modelTipocustofixo->load(Yii::$app->request->post()) && $modelTipocustofixo->save()) {
            return $this->redirect(['view', 'id' => $modelTipocustofixo->idtipocustofixo]);
        } else {
            return $this->render('update', [
                'modelTipocustofixo' => $modelTipocustofixo,
            ]);
        }
    }

    /**
     * Deletes an existing Tipocustofixo model.
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

        $searchModel = new TipocustofixoSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mensagem' => $mensagem

        ]);
    }

    /**
     * Finds the Tipocustofixo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tipocustofixo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelTipocustofixo = Tipocustofixo::findOne($id)) !== null) {
            return $modelTipocustofixo;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
