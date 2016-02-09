<?php

namespace app\controllers;

use Yii;
use app\models\Relatorio;
use app\models\RelatorioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
/**
 * RelatorioController implements the CRUD actions for Relatorio model.
 */
class RelatorioController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
        'roles' => ['relatorio'],
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
     * Lists all Relatorio models.
     * @return mixed
     */
    public function actionIndex()
    {
     if (Yii::$app->user->can("index-relatorio") ||
        Yii::$app->user->can("relatorio") ) {
        $searchModel = new RelatorioSearch();
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
     * Displays a single Relatorio model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       if (Yii::$app->user->can("view-relatorio") ||
        Yii::$app->user->can("relatorio") ) {
        return $this->render('view', [
            'model' => $this->findModel($id),
            ]);
}else{
    throw new ForbiddenHttpException("Acesso negado!");
}
}

    /**
     * Creates a new Relatorio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       if (Yii::$app->user->can("create-relatorio") ||
        Yii::$app->user->can("relatorio") ) {
        $model = new Relatorio();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->idrelatorio]);
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
     * Updates an existing Relatorio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       if (Yii::$app->user->can("update-relatorio") ||
        Yii::$app->user->can("relatorio") ) {
        $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->idrelatorio]);
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
     * Deletes an existing Relatorio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      if (Yii::$app->user->can("delete-relatorio") ||
        Yii::$app->user->can("relatorio") ) {
        $this->findModel($id)->delete();

    return $this->redirect(['index']);
}else{
    throw new ForbiddenHttpException("Acesso negado!");
}
}

    /**
     * Finds the Relatorio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Relatorio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Relatorio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
