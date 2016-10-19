<?php

namespace app\controllers;

use app\components\AccessFilter;
use app\models\Tipocustofixo;
use Yii;
use app\models\Custofixo;
use app\models\CustofixoSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustofixoController implements the CRUD actions for Custofixo model.
 */
class CustofixoController extends Controller
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

                    'custofixo' => [
                        'index-custofixo',
                        'update-custofixo',
                        'delete-custofixo',
                        'view-custofixo',
                        'create-custofixo',
                    ],

                    'index' => 'index-custofixo',
                    'update' => 'update-custofixo',
                    'delete' => 'delete-custofixo',
                    'view' => 'view-custofixo',
                    'create' => 'create-custofixo',
                ],
            ],
        ];
    }

    /**
     * Lists all Custofixo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustofixoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Custofixo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelCustofixo' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Custofixo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new Custofixo();
        $tiposCustoFixo = ArrayHelper::map(Tipocustofixo::find()->all(),
            'idtipocustofixo','tipocustofixo');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idconta]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'tiposCustoFixo'=>$tiposCustoFixo,
            ]);
        }
    }*/

    /**
     * Updates an existing Custofixo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelCustofixo = $this->findModel($id);
        $tiposCustoFixo = ArrayHelper::map(Tipocustofixo::find()->all(),
            'idtipocustofixo','tipocustofixo');
        if ($modelCustofixo->load(Yii::$app->request->post()) && $modelCustofixo->save()) {
            return $this->redirect(['view', 'id' => $modelCustofixo->idconta]);
        } else {
            return $this->render('update', [
                'modelCustofixo' => $modelCustofixo,
                'tiposCustoFixo'=>$tiposCustoFixo,
            ]);
        }
    }

    /**
     * Deletes an existing Custofixo model.
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
     * Finds the Custofixo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Custofixo the loaded modelCustofixo
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelCustofixo = Custofixo::findOne($id)) !== null) {
            return $modelCustofixo;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
