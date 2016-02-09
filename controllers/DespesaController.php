<?php

namespace app\controllers;

use Yii;
use app\models\Despesa;
use app\models\DespesaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
/**
 * DespesaController implements the CRUD actions for Despesa model.
 */
class DespesaController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
        'roles' => ['despesa'],
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
     * Lists all Despesa models.
     * @return mixed
     */
    public function actionIndex()
    {
      if (Yii::$app->user->can("index-despesa") ||
        Yii::$app->user->can("despesa") ) {
        $searchModel = new DespesaSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        ]);
}else{
    throw new ForbiddenHttpException("Acesso negado!");
}
}

    /**
     * Displays a single Despesa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can("view-despesa") ||
            Yii::$app->user->can("despesa") ) {
           $formatter = \Yii::$app->formatter;
       return $this->render('view', [
        'model' => $this->findModel($id),
        'formatter'=>$formatter,
        ]);
   }else{
    throw new ForbiddenHttpException("Acesso negado!");
}
}

    /**
     * Creates a new Despesa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if (Yii::$app->user->can("create-despesa") ||
            Yii::$app->user->can("despesa") ) {
            $model = new Despesa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->iddespesa]);
        } else {
            return $this->render('create', [
                'model' => $model,
                ]);
        }
    }else{
        throw new ForbiddenHttpException("Acesso negado!");
    }
}

    /**
     * Updates an existing Despesa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
     if (Yii::$app->user->can("update-despesa") ||
        Yii::$app->user->can("despesa") ) {
        $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->iddespesa]);
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
     * Deletes an existing Despesa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       if (Yii::$app->user->can("delete-despesa") ||
        Yii::$app->user->can("despesa") ) {
        $this->findModel($id)->delete();

    return $this->redirect(['index']);
}else{
    throw new ForbiddenHttpException("Acesso negado!");
}
}

    /**
     * Finds the Despesa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Despesa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Despesa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
