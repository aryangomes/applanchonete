<?php

namespace app\controllers;

use Yii;
use app\models\Categoria;
use app\models\CategoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\AccessFilter;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends Controller
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

                    'categoria' => [
                        'index-categoria',
                        'update-categoria',
                        'delete-categoria',
                        'view-categoria',
                        'create-categoria',

                    ],

                    'index' => 'index-categoria',
                    'update' => 'update-categoria',
                    'delete' => 'delete-categoria',
                    'view' => 'view-categoria',
                    'create' => 'create-categoria',

                ],
            ],
        ];
    }

    /**
     * Lists all Categoria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categoria model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelCategoria' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Categoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelCategoria = new Categoria();

        if ($modelCategoria->load(Yii::$app->request->post()) && $modelCategoria->save()) {
            return $this->redirect(['view', 'id' => $modelCategoria->idCategoria]);
        } else {
            return $this->render('create', [
                'modelCategoria' => $modelCategoria,
            ]);
        }
    }

    /**
     * Updates an existing Categoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelCategoria = $this->findModel($id);

        if ($modelCategoria->load(Yii::$app->request->post()) && $modelCategoria->save()) {
            return $this->redirect(['view', 'id' => $modelCategoria->idCategoria]);
        } else {
            return $this->render('update', [
                'modelCategoria' => $modelCategoria,
            ]);
        }
    }

    /**
     * Deletes an existing Categoria model.
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

        $searchModel = new CategoriaSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mensagem' => $mensagem

        ]);
    }

    /**
     * Finds the Categoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categoria the loaded modelCategoria
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelCategoria = Categoria::findOne($id)) !== null) {
            return $modelCategoria;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
