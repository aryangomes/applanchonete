<?php

namespace app\controllers;

use Yii;
use app\models\Caixa;
use app\models\CaixaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
/**
 * CaixaController implements the CRUD actions for Caixa model.
 */
class CaixaController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
        'roles' => ['caixa','index-caixa'],
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
     * Lists all Caixa models.
     * @return mixed
     */
    public function actionIndex()
    {

        if (Yii::$app->user->can("index-caixa") ||
            Yii::$app->user->can("caixa") ) {
            $caixa = Caixa::find()->where(['user_id'=>Yii::$app->user->getId()])->one();
      //  var_dump($caixa);
        if (count($caixa) > 0) {
            return $this->redirect(['view', 'id'=>$caixa->idcaixa]);
        }else{

            $searchModel = new CaixaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                ]);
        }
    }else{
        throw new ForbiddenHttpException("Acesso negado!");
    }
}

    /**
     * Displays a single Caixa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        if (Yii::$app->user->can("view-caixa") ||
            Yii::$app->user->can("caixa") ) {
            return $this->render('view', [
                'model' => $this->findModel($id),
                ]);
    }else{
        throw new ForbiddenHttpException("Acesso negado!");
    }
}

    /**
     * Creates a new Caixa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       if (Yii::$app->user->can("create-caixa") ||
        Yii::$app->user->can("caixa") ) {
          $caixa = Caixa::find()->where(['user_id'=>Yii::$app->user->getId()])->one();

      if (count($caixa) == 0) {

        $model = new Caixa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idcaixa]);
        } else {
            return $this->render('create', [
                'model' => $model,
                ]);
        }
    }else{
        return $this->redirect(['view', 'id'=>$caixas->idcaixa]);

    }
}else{
    throw new ForbiddenHttpException("Acesso negado!");
}
}

    /**
     * Updates an existing Caixa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
     if (Yii::$app->user->can("update-caixa") ||
        Yii::$app->user->can("caixa") ) {
        $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->idcaixa]);
    } else {
        return $this->render('update', [
            'model' => $model,
            ]);
    }
}else{
    throw new ForbiddenHttpException("Acesso negado!");
}
}

    /**
     * Deletes an existing Caixa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        if (Yii::$app->user->can("delete-caixa") ||
            Yii::$app->user->can("caixa") ) {
            $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }else{
        throw new ForbiddenHttpException("Acesso negado!");
    }
}

    /**
     * Finds the Caixa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Caixa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Caixa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
