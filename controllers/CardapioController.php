<?php

namespace app\controllers;

use app\models\Insumo;
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
                    'get-foto-produto' => 'create-cardapio',

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

        //Recebe os itens do cardápio
        $itensCardapio = Itemcardapio::find()->where(
            ['idCardapio' => $id]
        )->orderBy('ordem ASC')->all();

        //Recebe os insumos do Produto Venda do item do Cardápio
        $insumosProdutos = [];


        foreach ($itensCardapio as $ic) {
            //Array para guardar os nomes dos insumos do Produto Venda
            $aux = [];

            $produtoVenda = Produto::findOne($ic->idProduto);

            if ($produtoVenda != null) {
                $insumos = Insumo::findAll(['idProdutoVenda' => $produtoVenda->idProduto]);
                foreach ($insumos as $i) {

                    array_push($aux, $i->produtoInsumo->nome);
                }
                //Adiciona os insumos produtos na lista de insumos do produto
                //do item do cardápio
                array_push($insumosProdutos, $aux);
            }

        }

        return $this->render('view', [
            'modelCardapio' => $this->findModel($id),
            'itensCardapio' => $itensCardapio,
            'insumosProdutos' => $insumosProdutos,
        ]);

    }

    /**
     * Creates a new Cardapio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $modelCardapio = new Cardapio();

        $modelItemCardapio = new Itemcardapio();

        $mensagem = "";

        $produtos = ArrayHelper::map(Produto::find()->
        where(['isInsumo' => 0])->orderBy('nome ASC')->all(), 'idProduto', 'nome');


        if ($modelCardapio->load(Yii::$app->request->post())) {

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {

                $itensInseridos = true;

                if ($modelCardapio->save()) {

                    $itensCardapio = Yii::$app->request->post()['Itemcardapio'];

                    for ($i = 0; $i < count($itensCardapio['idProduto']); $i++) {

                        $itemCardapio = new Itemcardapio();

                        $itemCardapio->idCardapio = $modelCardapio->idCardapio;

                        $itemCardapio->idProduto = $itensCardapio['idProduto'][$i];

                        $itemCardapio->ordem = $itensCardapio['ordem'][$i];


                        if (!$itemCardapio->save()) {
                            $itensInseridos = false;
                        }
                    }

                    if ($itensInseridos) {

                        $transaction->commit();

                        return $this->redirect(['view', 'id' => $modelCardapio->idCardapio]);

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
        $modelCardapio->data = date('Y-m-d');

        return $this->render('create', [
            'modelCardapio' => $modelCardapio,
            'modelItemCardapio' => $modelItemCardapio,
            'mensagem' => $mensagem,
            'produtos' => $produtos,
        ]);


    }

    /**
     * Updates an existing Cardapio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $modelCardapio = $this->findModel($id);

        $modelItemCardapio = new Itemcardapio();

        $mensagem = "";

        $itensCardapio = Itemcardapio::find()
            ->where(['idCardapio' => $id])
            ->orderBy('ordem ASC')
            ->all();

        $produtos = ArrayHelper::map(Produto::find()->
        where(['isInsumo' => 0])->all(), 'idProduto', 'nome');


        if ($modelCardapio->load(Yii::$app->request->post())) {

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {

                $itensInseridos = true;

                if ($modelCardapio->save()) {


                    if (Itemcardapio::deleteAll(['idCardapio' => $id]) > 0) {

                        $itensCardapio = Yii::$app->request->post()['Itemcardapio'];

                        for ($i = 0; $i < count($itensCardapio['idProduto']); $i++) {

                            $itemCardapio = new Itemcardapio();

                            $itemCardapio->idCardapio = $modelCardapio->idCardapio;

                            $itemCardapio->idProduto = $itensCardapio['idProduto'][$i];

                            $itemCardapio->ordem = $itensCardapio['ordem'][$i];

                            if (!$itemCardapio->save()) {
                                $itensInseridos = false;
                            }
                        }

                        if ($itensInseridos) {
                            $transaction->commit();

                            return $this->redirect(['view', 'id' => $modelCardapio->idCardapio]);
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
            'modelCardapio' => $modelCardapio,
            'modelItemCardapio' => $modelItemCardapio,
            'mensagem' => $mensagem,
            'itensCardapio' => $itensCardapio,
            'produtos' => $produtos,
        ]);

    }

    /**
     * Deletes an existing Cardapio model.
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

        $searchModel = new CardapioSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mensagem' => $mensagem

        ]);

    }

    /**
     * Finds the Cardapio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cardapio the loaded modelCardapio
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelCardapio = Cardapio::findOne($id)) !== null) {
            return $modelCardapio;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Recupera a foto do produto
     * @param $idProduto
     * @return string
     */
    public function actionGetFotoProduto($idProduto)
    {
        if (isset($idProduto)) {
            $produto = Produto::findOne($idProduto);

            if ($produto != null) {
                return Json::encode([($produto->nome), base64_encode($produto->foto)]);
            } else {
                return Json::encode(false);
            }
        }
        throw new NotFoundHttpException('Passe o id do Produto.');
    }
}
