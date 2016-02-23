<?php

namespace app\controllers;

use Yii;
use app\models\Historicosituacao;
use app\models\HistoricosituacaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HistoricosituacaoController implements the CRUD actions for Historicosituacao model.
 */
class HistoricosituacaoController extends Controller
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
        ];
    }

    /**
     * Lists all Historicosituacao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HistoricosituacaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Historicosituacao model.
     * @param integer $idPedido
     * @param integer $idSituacaoPedido
     * @return mixed
     */
    public function actionView($idPedido, $idSituacaoPedido)
    {
        return $this->render('view', [
            'model' => $this->findModel($idPedido, $idSituacaoPedido),
        ]);
    }

    /**
     * Creates a new Historicosituacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Historicosituacao();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idPedido' => $model->idPedido, 'idSituacaoPedido' => $model->idSituacaoPedido]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Historicosituacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idPedido
     * @param integer $idSituacaoPedido
     * @return mixed
     */
    public function actionUpdate($idPedido, $idSituacaoPedido)
    {
        $model = $this->findModel($idPedido, $idSituacaoPedido);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idPedido' => $model->idPedido, 'idSituacaoPedido' => $model->idSituacaoPedido]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Historicosituacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idPedido
     * @param integer $idSituacaoPedido
     * @return mixed
     */
    public function actionDelete($idPedido, $idSituacaoPedido)
    {
        $this->findModel($idPedido, $idSituacaoPedido)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Historicosituacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idPedido
     * @param integer $idSituacaoPedido
     * @return Historicosituacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idPedido, $idSituacaoPedido)
    {
        if (($model = Historicosituacao::findOne(['idPedido' => $idPedido, 'idSituacaoPedido' => $idSituacaoPedido])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
