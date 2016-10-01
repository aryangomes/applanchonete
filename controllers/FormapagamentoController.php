<?php

namespace app\controllers;

use Yii;
use app\models\Formapagamento;
use app\models\FormapagamentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FormapagamentoController implements the CRUD actions for Formapagamento model.
 */
class FormapagamentoController extends Controller
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
     * Lists all Formapagamento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FormapagamentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Formapagamento model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelFormapagamento' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Formapagamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelFormapagamento = new Formapagamento();

        if ($modelFormapagamento->load(Yii::$app->request->post()) && $modelFormapagamento->save()) {
            return $this->redirect(['view', 'id' => $modelFormapagamento->idTipoPagamento]);
        } else {
            return $this->render('create', [
                'modelFormapagamento' => $modelFormapagamento,
            ]);
        }
    }

    /**
     * Updates an existing Formapagamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelFormapagamento = $this->findModel($id);

        if ($modelFormapagamento->load(Yii::$app->request->post()) && $modelFormapagamento->save()) {
            return $this->redirect(['view', 'id' => $modelFormapagamento->idTipoPagamento]);
        } else {
            return $this->render('update', [
                'modelFormapagamento' => $modelFormapagamento,
            ]);
        }
    }

    /**
     * Deletes an existing Formapagamento model.
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
     * Finds the Formapagamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Formapagamento the loaded modelFormapagamento
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelFormapagamento = Formapagamento::findOne($id)) !== null) {
            return $modelFormapagamento;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
