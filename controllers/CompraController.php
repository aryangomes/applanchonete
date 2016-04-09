<?php

namespace app\controllers;
use yii\web\HttpException;
use Yii;
use app\models\Compra;
use app\models\Fornecedor;
use app\models\CompraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\components\AccessFilter;
/**
 * CompraController implements the CRUD actions for Compra model.
 */
class CompraController extends Controller
{
    public function behaviors()
    {
        return [
     /*   'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
        'roles' => ['compra','index-compra'],
        ],
        ]
        ],*/
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'delete' => ['post'],
        ],
        ],
        'autorizacao'=>[
        'class'=>AccessFilter::className(),
        'actions'=>[

        'compra'=>[
        'index-compra',
        'update-compra',
        'delete-compra',
        'view-compra',
        'create-compra',
        ],

        'index'=>'index-compra',
        'update'=>'update-compra',
        'delete'=>'delete-compra',
        'view'=>'view-compra',
        'create'=>'create-compra',
        ],
        ],
        ];
    }

    /**
     * Lists all Compra models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new CompraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ]);


    }

    /**
     * Displays a single Compra model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $compra = new Compra();

        //var_dump($id);
       // var_dump($idFornecedor->fornecedor_idFornecedor);
        $formatter = \Yii::$app->formatter;
        return $this->render('view', [
            'model' => $this->findModel($id),

            'formatter'=>$formatter,
            ]);


    }

    /**
     * Creates a new Compra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

      $model = new Compra();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->idcompra]);
    } else {
        return $this->render('create', [
            'model' => $model,
            
            ]);
    }

}

    /**
     * Updates an existing Compra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

     $fornecedores= ArrayHelper::map(
        Fornecedor::find()->all(), 
        'idFornecedor','nome');
     $model = $this->findModel($id);

     if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->idcompra]);
    } else {
        return $this->render('update', [
            'model' => $model,
            'fornecedores'=>$fornecedores,
            ]);
    }

}

    /**
     * Deletes an existing Compra model.
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
     * Finds the Compra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Compra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compra::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
