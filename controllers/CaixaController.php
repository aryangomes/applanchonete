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
use app\components\AccessFilter;

/**
 * CaixaController implements the CRUD actions for Caixa model.
 */
class CaixaController extends Controller
{

    public function behaviors()
    {
        return [
            /* 'access' =>[
            'class' => AccessControl::classname(),
            'only'=> ['create','update','view','delete','index'],
            'rules'=> [
            ['allow'=>true,
            'roles' => ['caixa','index-caixa'],
            ],

            ]
            ],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],

            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'caixa' => [
                        'index-caixa',
                        'update-caixa',
                        'delete-caixa',
                        'view-caixa',
                        'create-caixa',
                        'fechar-caixa'
                    ],

                    'index' => 'index-caixa',
                    'update' => 'update-caixa',
                    'delete' => 'delete-caixa',
                    'view' => 'view-caixa',
                    'create' => 'create-caixa',
                    'fechar' => 'fechar-caixa'
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


        $ultimocaixa = Yii::$app->db->createCommand('SELECT * FROM caixa ORDER BY idcaixa DESC LIMIT 1')->queryOne();


        if ($ultimocaixa != null && empty($ultimocaixa['datafechamento'])) {
            return $this->redirect(['view', 'id' => $ultimocaixa['idcaixa']]);
        } else {

            $searchModel = new CaixaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Caixa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelCaixa' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Caixa modelCaixa.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        // $caixa = new Caixa(); 
        $caixas = Caixa::find()->all();

        $modelCaixa = new Caixa();
        $modelCaixa->dataabertura = date('Y-m-d');
        if ($modelCaixa->load(Yii::$app->request->post()) && $modelCaixa->save()) {
            return $this->redirect(['view', 'id' => $modelCaixa->idcaixa]);
        } else {
            $modelCaixa->valorapurado = 0;
            $modelCaixa->valoremcaixa = 0;
            $modelCaixa->valorlucro = 0;
            return $this->render('create', [
                'modelCaixa' => $modelCaixa,
            ]);
        }
        // $caixa = Caixa::find()->where(['user_id'=>Yii::$app->user->getId()])->one(); 
    }

    /**
     * Updates an existing Caixa modelCaixa.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $modelCaixa = $this->findModel($id);

        $ultimocaixa = Caixa::find()->where(['datafechamento' => null])
            ->orderBy('idcaixa DESC')->all();
        //SELECT ID FROM tabela ORDER BY ID DESC LIMIT 1
        if (!empty($ultimocaixa)) {
            if ($modelCaixa->load(Yii::$app->request->post()) && $modelCaixa->save()) {
                return $this->redirect(['view', 'id' => $modelCaixa->idcaixa]);
            } else {
                return $this->render('update', [
                    'modelCaixa' => $modelCaixa,
                ]);
            }
        } else {
            throw new NotFoundHttpException('O caixa não está aberto');

            return $this->render('update', [
                'modelCaixa' => $modelCaixa,
            ]);
        }
    }

    /**
     * Deletes an existing Caixa modelCaixa.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {


        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionFechar($id)
    {

        $modelCaixa = $this->findModel($id);
        $data = date('Y-m-d');

        Yii::$app->db->createCommand()->update('caixa', ['datafechamento' => $data], 'idcaixa = :idcaixa', ['idcaixa' => $modelCaixa->idcaixa])->execute();

        // Yii::$app->db->createCommand()->update('apartamento', ['estado' => 'Ocupado'], 'numero = :param', ['param' => $modelCaixa->apartamento])->execute();

        return $this->redirect(['index']);
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
        if (($modelCaixa = Caixa::findOne($id)) !== null) {
            return $modelCaixa;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
