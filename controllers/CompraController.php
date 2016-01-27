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
/**
 * CompraController implements the CRUD actions for Compra model.
 */
class CompraController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
        'roles' => ['gerente'],
        ],
        ]
        ],
        'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
        'delete' => ['post'],
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
        $idFornecedor = $compra::find('fornecedor_idFornecedor')->where(['idcompra'=>$id])->one();
        $fornecedor = new Fornecedor();
        //var_dump($id);
       // var_dump($idFornecedor->fornecedor_idFornecedor);
        $fornecedor = $fornecedor::getNomeFornecedor($idFornecedor->fornecedor_idFornecedor);
        $formatter = \Yii::$app->formatter;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'fornecedor'=>$fornecedor,
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

      $fornecedores= ArrayHelper::map(
        Fornecedor::find()->all(), 
        'idFornecedor','nome');
      $model = new Compra();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->idcompra]);
    } else {
        return $this->render('create', [
            'model' => $model,
            'fornecedores'=>$fornecedores,
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
