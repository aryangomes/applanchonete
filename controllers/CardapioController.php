<?php

namespace app\controllers;

use app\models\Itemcardapio;
use app\models\Produto;
use Yii;
use app\models\Cardapio;
use app\models\CardapioSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\components\AccessFilter;

/**
 * CardapioController implements the CRUD actions for Cardapio model.
 */
class CardapioController extends Controller
{
    public function behaviors()
    {
        return [
//        'access' =>[
//        'class' => AccessControl::classname(),
//        'only'=> ['create','update','view','delete','index'],
//        'rules'=> [
//        ['allow'=>true,
//        'rules' => ['cardapio','index-cardapio'],
//        ],
//        ]
//        ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],

            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'cardapio' => [
                        'index-cardapio',
                        'update-cardapio',
                        'delete-cardapio',
                        'view-cardapio',
                        'create-cardapio',
                        'get-foto-produto'
                    ],

                    'index' => 'index-cardapio',
                    'update' => 'update-cardapio',
                    'delete' => 'delete-cardapio',
                    'view' => 'view-cardapio',
                    'create' => 'create-cardapio',
                    'get-foto-produto' => 'cardapio',
                ],
            ],
        ];
    }

    /**
     * Lists all Cardapio models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can("index-cardapio") ||
            Yii::$app->user->can("cardapio")
        ) {
            $searchModel = new CardapioSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Displays a single Cardapio model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can("view-cardapio") ||
            Yii::$app->user->can("cardapio")
        ) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Creates a new Cardapio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can("create-cardapio") ||
            Yii::$app->user->can("cardapio")
        ) {
            $model = new Cardapio();

            $modelItemCardapio = new Itemcardapio();

            $mensagem = "";

            $produtos = Produto::getListToDropDownList();

            /*$produtos = ArrayHelper::map(
                Produto::find()->all(),
                'idProduto','nome'
            );*/

            if ($model->load(Yii::$app->request->post())) {

                //Inicia a transação:
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $itensInseridos = true;

                    if ($model->save()) {

                        $itensCardapio = Yii::$app->request->post()['Itemcardapio'];

                        for ($i = 0; $i < count($itensCardapio['idProduto']); $i++) {
                            $itemCardapio = new Itemcardapio();
                            $itemCardapio->idCardapio = $model->idCardapio;
                            $itemCardapio->idProduto = $itensCardapio['idProduto'][$i];
                            $itemCardapio->ordem = $itensCardapio['ordem'][$i];
                            var_dump($itensCardapio['idProduto'][$i]);
                            if (!$itemCardapio->save()) {
                                $itensInseridos = false;
                            }
                        }

                        if ($itensInseridos) {
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->idCardapio]);
                        } else {
                            $mensagem = "Não foi possível salvar os dados";
                            $transaction->rollBack(); //desfaz alterações no BD

                        }

                    }

                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    $mensagem = "Ocorreu uma falha inesperada ao tentar salvar";
                }

            }
            //Seta o fuso horário brasileiro
            date_default_timezone_set('America/Sao_Paulo');
            $model->data = date('Y-m-d');

            return $this->render('create', [
                'model' => $model,
                'modelItemCardapio' => $modelItemCardapio,
                'mensagem' => $mensagem,
                'produtos'=>$produtos,
            ]);


        } else {
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Updates an existing Cardapio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can("update-cardapio") ||
            Yii::$app->user->can("cardapio")
        ) {
            $model = $this->findModel($id);
            $modelItemCardapio = new Itemcardapio();

            $mensagem = "";

//            $itensCardapio = Itemcardapio::findAll(['idCardapio' => $id]);
            $itensCardapio = Itemcardapio::find()
                ->where(['idCardapio' => $id])
                ->orderBy('ordem ASC')
                ->all();
            $produtos = Produto::getListToDropDownList();

            if ($model->load(Yii::$app->request->post())) {

                //Inicia a transação:
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $itensInseridos = true;

                    if ($model->save()) {


                        if (Itemcardapio::deleteAll(['idCardapio' => $id]) > 0) {

                            $itensCardapio = Yii::$app->request->post()['Itemcardapio'];

                            for ($i = 0; $i < count($itensCardapio['idProduto']); $i++) {
                                $itemCardapio = new Itemcardapio();
                                $itemCardapio->idCardapio = $model->idCardapio;
                                $itemCardapio->idProduto = $itensCardapio['idProduto'][$i];
                                $itemCardapio->ordem = $itensCardapio['ordem'][$i];

                                if (!$itemCardapio->save()) {
                                    $itensInseridos = false;
                                }
                            }

                            if ($itensInseridos) {
                                $transaction->commit();
                                return $this->redirect(['view', 'id' => $model->idCardapio]);
                            } else {
                                $mensagem = "Não foi possível salvar os dados";
                                $transaction->rollBack(); //desfaz alterações no BD

                            }
                        }
                    }

                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    $mensagem = "Ocorreu uma falha inesperada ao tentar salvar";
                }

            }
            //Seta o fuso horário brasileiro
            date_default_timezone_set('America/Sao_Paulo');


            return $this->render('update', [
                'model' => $model,
                'modelItemCardapio' => $modelItemCardapio,
                'mensagem' => $mensagem,
                'itensCardapio'=>$itensCardapio,
                'produtos'=>$produtos,
            ]);
        } else {
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Deletes an existing Cardapio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can("delete-cardapio") ||
            Yii::$app->user->can("cardapio")
        ) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException("Acesso negado!");
        }
    }

    /**
     * Finds the Cardapio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cardapio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cardapio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    public function actionGetFotoProduto($idProduto)
    {
        if(isset($idProduto)){
            $produto = Produto::findOne($idProduto);

            if($produto !=null){
                return Json::encode([($produto->nome),base64_encode($produto->foto)]);
            }else{
                return Json::encode(false);
            }
        }
    }
}
