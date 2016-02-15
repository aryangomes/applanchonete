<?php

namespace app\controllers;

use Yii;
use app\models\Fornecedor;
use app\models\FornecedorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * FornecedorController implements the CRUD actions for Fornecedor model.
 */
class FornecedorController extends Controller
{
    public function behaviors()
    {
        return [
        'access' =>[
        'class' => AccessControl::classname(),
        'only'=> ['create','update','view','delete','index'],
        'rules'=> [
        ['allow'=>true,
        'roles' => ['fornecedor','index-fornecedor'],
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
     * Lists all Fornecedor models.
     * @return mixed
     */
    public function actionIndex()
    {
     if (Yii::$app->user->can("index-fornecedor") ||
        Yii::$app->user->can("fornecedor") ) {
        $searchModel = new FornecedorSearch();
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
     * Displays a single Fornecedor model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    { 
        if (Yii::$app->user->can("view-fornecedor") ||
            Yii::$app->user->can("fornecedor") ) {
            return $this->render('view', [
                'model' => $this->findModel($id),
                ]);

    }else{
        throw new ForbiddenHttpException("Acesso negado!");
    }
}


    /**
     * Creates a new Fornecedor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-fornecedor") ||
            Yii::$app->user->can("fornecedor") ) {
            $model = new Fornecedor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idFornecedor]);
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
     * Updates an existing Fornecedor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

       if (Yii::$app->user->can("update-fornecedor") ||
        Yii::$app->user->can("fornecedor") ) {
        $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->idFornecedor]);
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
     * Deletes an existing Fornecedor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {


       if (Yii::$app->user->can("delete-fornecedor") ||
        Yii::$app->user->can("fornecedor") ) {
        $this->findModel($id)->delete();

    return $this->redirect(['index']);

}else{
    throw new ForbiddenHttpException("Acesso negado!");
}
}

    /**
     * Finds the Fornecedor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fornecedor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fornecedor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
