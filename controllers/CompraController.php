<?php

namespace app\controllers;

use app\components\AccessFilter;
use app\models\Categoria;
use app\models\Contasapagar;
use Yii;
use app\models\Compra;
use app\models\CompraSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Conta;
use app\models\Compraproduto;
use app\models\Produto;
use yii\helpers\ArrayHelper;

/**
 * CompraController implements the CRUD actions for Compra model.
 */
class CompraController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],

            ],

            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'compra' => [
                        'index-compra',
                        'update-compra',
                        'delete-compra',
                        'view-compra',
                        'create-compra',

                    ],

                    'index' => 'index-compra',
                    'update' => 'update-compra',
                    'delete' => 'delete-compra',
                    'view' => 'view-compra',
                    'create' => 'create-compra',
                    'get-foto-produto' => 'compra',

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
        $compraProdutos = Compraproduto::find()->where(['idCompra' => $id])
            ->all();

        return $this->render('view', [
            'modelCompra' => $this->findModel($id),
            'compraProdutos' => $compraProdutos,
            'produtosValorAlterado' => $_GET['produtosValorAlterado']
        ]);
    }

    /**
     * Creates a new Compra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelCompra = new Compra();

        $mensagem = ""; //Informa ao usuário mensagens de erro na view
        $produtosValorAlterado = [];

        $conta = new Conta();

        $compraProduto = new Compraproduto();

        $produtos = ArrayHelper::map(Produto::find()->
        where(['isInsumo' => 1])->orderBy('nome ASC')->all(),
            'idProduto', 'nome');

        //Recebe o valor total da compra
        $valorTotalDaCompra = 0;

        $categorias = ArrayHelper::map(
            Categoria::find()->all(),
            'idCategoria', 'nome');

        $novoProduto = new Produto();

        $arrayFinal = [];
        $arrayIds = [];
        //Setando valor padrão para a compra
        $modelCompra->valor = 0;

        //Setando tipo de conta padrão para a compra
        $modelCompra->tipoConta = 'contasapagar';

        //Setando situação de pagamento padrão para a compra
        $modelCompra->situacaoPagamento = 1;

        //Setando o fuso horário
        date_default_timezone_set('America/Recife');

        if ((Yii::$app->request->post())) {

            $conta->tipoConta = 'contasapagar';

            $conta->descricao = 'Compra de ' . date('d/m/Y', strtotime(Yii::$app->request->post()['Compra']['dataCompra']));

            $conta->descricao = 'Compra de ' . date('d/m/Y', strtotime(Yii::$app->request->post()['Compra']['dataCompra']));

            $compraprodutos = Yii::$app->request->post()['Compraproduto'];

            $valorescompraprodutos = Yii::$app->request->post()['compraproduto-valorcompra-disp'];



            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                //Tenta salvar um registro :

                if ($conta->save(false)) {

                    $itensInseridos = true;

                    $modelContasAPagar = new Contasapagar();

                    $modelContasAPagar->idconta = $conta->idconta;

                    $arrayIdsProdutoVenda = [];

                    $indice = 0;

                    $modelCompra->idconta = $conta->idconta;

                    $modelCompra->dataCompra = Yii::$app->request->post()['Compra']['dataCompra'];


                    if ($modelContasAPagar->save(false) && $modelCompra->save()) {
                        $compraprodutos = Yii::$app->request->post()['Compraproduto'];

                        $valorescompraprodutos = Yii::$app->request->post()['compraproduto-valorcompra-disp'];


                        for ($i = 0; $i < count($compraprodutos['idProduto']); $i++) {

                            $cp = new Compraproduto();

                            $cp->idCompra = $modelCompra->idconta;

                            $cp->idProduto = $compraprodutos['idProduto'][$i];

                            $cp->quantidade = $compraprodutos['quantidade'][$i];

                            $cp->valorCompra = $valorescompraprodutos[$i];

                            if ($cp->comparaPrecoProduto($cp)) {

                                $lp = $novoProduto->getListaInsumos($cp->idProduto);

                                foreach ($lp as $key) {

                                    $produto = Yii::$app->db->createCommand('SELECT idProduto, nome FROM produto WHERE idProduto = :id ', ['id' => $key['idprodutoVenda']])->queryOne();

                                    array_push($produtosValorAlterado, $produto);
                                }
                            }

                            for ($j = 0; $j < count($produtosValorAlterado); $j++) {
                                array_push($arrayIds, $produtosValorAlterado[$j]['idProduto']);
                            }

                            $arrayIds = array_unique($arrayIds);

                            foreach ($arrayIds as $id) {
                                $produto = Yii::$app->db->createCommand('SELECT idProduto, nome FROM produto WHERE idProduto = :id ', ['id' => $id])->queryOne();

                                array_push($arrayFinal, $produto);

                            }

                            if (!$cp->save(false)) {
                                $mensagem = "Não foi possível salvar os dados";
                                $transaction->rollBack(); //desfaz alterações no BD
                                $itensInseridos = false;
                                break; //encerra o laço for
                            } else {
                                $valorTotalDaCompra += floatval($cp->valorCompra);
                            }

                        }

                        $modelCompra->valor = $valorTotalDaCompra;

                        if (!$modelCompra->save(false)) {

                            $mensagem = "Não foi possível salvar os dados ";

                            $transaction->rollBack(); //desfaz alterações no BD

                            $itensInseridos = false;
                        } else {
                            $conta->valor = $modelCompra->valor;
                            if (!$conta->save(false)) {

                                $mensagem = "Não foi possível salvar os dados ";

                                $transaction->rollBack(); //desfaz alterações no BD

                                $itensInseridos = false;
                            }
                        }


                        if ($itensInseridos) {
                            $transaction->commit();

                            $compraProdutos = Compraproduto::find()->where(['idCompra' => $modelCompra->idconta])->all();


                            return $this->render('view', [
                                'modelCompra' => $this->findModel($modelCompra->idconta),
                                'compraProdutos' => $compraProdutos,
                                'produtosValorAlterado' => $arrayFinal
                            ]);
                        }

                    } else {
                        $transaction->rollBack();
                        $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
                    }


                } else {
                    $transaction->rollBack();
                    $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
                }
            } catch (\Exception $exception) {
                $transaction->rollBack();

                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
            }


        }
        $modelCompra->dataCompra = date('Y-m-d');

        return $this->render('create', [
            'modelCompra' => $modelCompra,
            'compraProduto' => $compraProduto,
            'produtos' => $produtos,
            'mensagem' => $mensagem,
            'categorias' => $categorias,
            'novoProduto' => $novoProduto,
        ]);
    }

    /**
     * Updates an existing Compra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelCompra = $this->findModel($id);

        $conta = Conta::findOne($modelCompra->idconta);

        $mensagem = ""; //Informa ao usuário mensagens de erro na view

        $compraProduto = new Compraproduto();

        $produtos = ArrayHelper::map(Produto::find()->
        where(['isInsumo' => 1])->orderBy('nome ASC')->all(),
            'idProduto', 'nome');

        $produtosDaCompras =
            Compraproduto::find()->where(['idCompra' => $id])->all();


        //Recebe o valor total da compra
        $valorTotalDaCompra = 0;

        $novoProduto = new Produto();
        $produtosValorAlterado = [];

        $arrayFinal = [];
        $arrayIds = [];

        if (Yii::$app->request->post()) {

            $itensInseridos = true;

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
//            try {

                $compraProdutoAux = (Yii::$app->request->post()['Compraproduto']);

                Yii::$app->db->createCommand(
                    "DELETE FROM compraproduto WHERE idCompra = :idCompra", [
                    ':idCompra' => $id,
                ])->execute();
                for ($i = 0; $i < count($compraProdutoAux['idProduto']); $i++) {


                    $cp = new Compraproduto();

                    $cp->idCompra = $id;

                    $cp->idProduto = $compraProdutoAux['idProduto'][$i];

                    $cp->quantidade = $compraProdutoAux['quantidade'][$i];

                    $cp->valorCompra = (Yii::$app->request->post()
                    ['compraproduto-valorcompra-disp'][$i]);

                    if ($cp->comparaPrecoProduto($cp)) {

                        $lp = $novoProduto->getListaInsumos($cp->idProduto);

                        foreach ($lp as $key) {

                            $produto = Yii::$app->db->createCommand('SELECT idProduto, nome FROM produto WHERE idProduto = :id ', ['id' => $key['idprodutoVenda']])->queryOne();

                            array_push($produtosValorAlterado, $produto);
                        }
                    }

                    for ($j = 0; $j < count($produtosValorAlterado); $j++) {
                        array_push($arrayIds, $produtosValorAlterado[$j]['idProduto']);
                    }

                    $arrayIds = array_unique($arrayIds);

                    foreach ($arrayIds as $id) {
                        $produto = Yii::$app->db->createCommand('SELECT idProduto, nome FROM produto WHERE idProduto = :id ', ['id' => $id])->queryOne();

                        array_push($arrayFinal, $produto);

                    }

                    if (!$cp->save(false)) {
                        $mensagem = "Não foi possível salvar os dados de algum";
                        $transaction->rollBack(); //desfaz alterações no BD
                        $itensInseridos = false;
                        break; //encerra o laço for
                    } else {

                        $valorTotalDaCompra += floatval($cp->valorCompra);

                    }

                }

                $modelCompra->valor = $valorTotalDaCompra;

                if (!$modelCompra->save(false)) {

                    $mensagem = "Não foi possível salvar os dados ";

                    $transaction->rollBack(); //desfaz alterações no BD

                    $itensInseridos = false;
                } else {
                    $conta->valor = $modelCompra->valor;
                    if (!$conta->save(false)) {

                        $mensagem = "Não foi possível salvar os dados ";

                        $transaction->rollBack(); //desfaz alterações no BD

                        $itensInseridos = false;
                    }
                }


                if ($itensInseridos) {
                    $transaction->commit();
                    return $this->redirect(['view',
                        'id' => $modelCompra->idconta,
                        'produtosValorAlterado' => $arrayFinal]);
                }

            /*} catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
            }*/
        }

        return $this->render('update', [
            'modelCompra' => $modelCompra,
            'compraProduto' => $compraProduto,
            'produtos' => $produtos,
            'produtosDaCompras' => $produtosDaCompras,
            'mensagem' => $mensagem,
        ]);
    }

    /**
     * Deletes an existing Compra model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $mensagem = "";

        //Inicia a transação:
        $transaction = \Yii::$app->db->beginTransaction();
        try {

            $itensDeletados = true;

            $produtosCompra = Compraproduto::find()
                ->where(['idCompra' => $id])->all();

            foreach ($produtosCompra as $pc) {

                $produto = Produto::findOne($pc->idProduto);

                $produto->quantidadeEstoque -= $pc->quantidade;

                if (!$produto->save()) {
                    $transaction->rollBack(); //desfaz alterações no BD
                    $itensDeletados = false;
                }
            }


            if ($itensDeletados) {
                $this->findModel($id)->delete();

                $transaction->commit();
                return $this->redirect(['index']);

            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
        }

        $searchModel = new CompraSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mensagem' => $mensagem

        ]);

    }

    /**
     * Finds the Compra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Compra the loaded modelCompra
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelCompra = Compra::findOne($id)) !== null) {
            return $modelCompra;
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
