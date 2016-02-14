<?php

namespace app\controllers;

use Yii;
use app\models\Loja;
use app\models\LojaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
/**
 * LojaController implements the CRUD actions for Loja model.
 */
class LojaController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
       // 'roles' => ['gerente'],
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
     * Lists all Loja models.
     * @return mixed
     */
    public function actionIndex()
    {
     if (Yii::$app->user->can("index-loja") ||
        Yii::$app->user->can("loja") ) {
        $searchModel = new LojaSearch();
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
     * Displays a single Loja model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
       if (Yii::$app->user->can("view-loja") ||
        Yii::$app->user->can("loja") ) {
        return $this->render('view', [
            'model' => $this->findModel($id),
            ]);
}else{
    throw new ForbiddenHttpException("Acesso negado!");
}
}

    /**
     * Creates a new Loja model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-loja") ||
            Yii::$app->user->can("loja") ) {
            $model = new Loja();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => Yii::$app->user->getId()]);
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
     * Updates an existing Loja model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
     if (Yii::$app->user->can("update-loja") ||
        Yii::$app->user->can("loja") ) {
        $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => Yii::$app->user->getId()]);
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
     * Deletes an existing Loja model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can("delete-loja") ||
            Yii::$app->user->can("loja") ) {
            $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }else{
        throw new ForbiddenHttpException("Acesso negado!");
    }
}

    /**
     * Finds the Loja model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Loja the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Loja::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
