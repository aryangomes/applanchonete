<?php

namespace app\controllers;

use app\models\Caixa;
use app\models\Historicosituacao;
use app\models\Mesa;
use Yii;
use app\models\Pedido;
use app\models\PedidoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Situacaopedido;
use yii\helpers\ArrayHelper;
use app\components\AccessFilter;
use app\models\Insumo;
use app\models\Itempedido;
use app\models\Formapagamento;
use app\models\Pagamento;
use app\models\Produto;
use yii\helpers\Json;

/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends Controller
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

                    'pedido' => [
                        'index-pedido',
                        'update-pedido',
                        'delete-pedido',
                        'view-pedido',
                        'create-pedido',
                        'finalizar-pedido',
                    ],
                    'index' => 'index-pedido',
                    'update' => 'update-pedido',
                    'delete' => 'delete-pedido',
                    'view' => 'view-pedido',
                    'create' => 'create-pedido',
                    'finalizar-pedido' => 'pedido',
                ],
            ],
        ];
    }

    /**
     * Lists all Pedido models.
     * @return mixed
     */
    public function actionIndex($situacaoDoPedido = 1)
    {
        $searchModel = new PedidoSearch();

        if (Yii::$app->request->get()) {
            $situacaoDoPedido = (Yii::$app->request->get()["situacao-pedido"]);
        }

        $dataProvider = $searchModel->searchPedidos($situacaoDoPedido);
        $situacaopedido = ArrayHelper::map(
            Situacaopedido::find()->all()
            , 'idSituacaoPedido', 'titulo');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'situacaopedido' => $situacaopedido,
            'situacaoDoPedido' => $situacaoDoPedido,
        ]);
    }

    /**
     * Displays a single Pedido model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $formasPagamento = ArrayHelper::map(
            Formapagamento::find()->all(), 'idTipoPagamento', 'titulo');

        $itemPedidoSearch = new PedidoSearch();
        $itensPedidos = $itemPedidoSearch->searchItensPedidoViewPedido($id);


        return $this->render('view', [
            'modelPedido' => $this->findModel($id),
            'formasPagamento' => $formasPagamento,
            'itensPedido' => $itensPedidos,
        ]);
    }

    /**
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //Carrega demais modelos
        $modelPedido = new Pedido();
        $itemPedido = new Itempedido();

        $mensagem = ""; //Informa ao usuário mensagens de erro na view
        $totalPedidoPagamento = "";

        $situacaopedido = ArrayHelper::map(
            Situacaopedido::find()->all()
            , 'idSituacaoPedido', 'titulo');

        $produtosVenda = ArrayHelper::map(
            Produto::find()->where(['isInsumo' => 0])->all(), 'idProduto', 'nome');

        $formasPagamento = ArrayHelper::map(
            Formapagamento::find()->all(), 'idTipoPagamento', 'titulo');

        //Recebe todas as mesas registradas
        $mesa = ArrayHelper::map(Mesa::find()
            ->all(), 'idMesa', 'numeroDaMesa');

        if ($modelPedido->load(Yii::$app->request->post())) {
            //Carrega demais modelos


            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                //Tenta salvar um registro de Pedido:
                if ($modelPedido->save() &&
                    ($modelPedido->cadastrarNovaHistoricoSituacaoPedido(intval($modelPedido->idPedido),
                        intval($modelPedido->idSituacaoAtual),
                        Yii::$app->getUser()->id))
                ) {
                    //alterei



                    //Carrega os dados dos itens do Pedido:
                    $itemPedidoPost = (Yii::$app->request->post()['Itempedido']);

                    $itensInseridos = true;


                    for ($i = 0; $i < count($itemPedidoPost['idProduto']); $i++) {
                        $itemPedido = new Itempedido();

                        $itemPedido->idProduto = $itemPedidoPost['idProduto'][$i];

                        $itemPedido->quantidade = $itemPedidoPost['quantidade'][$i];

                        $produtoVenda = Produto::find()->where(['idProduto' => $itemPedido->idProduto])->one();
                        $itemPedido->total = floatval(
                            number_format(
                                $produtoVenda->valorVenda * $itemPedido->quantidade, 2));

                        $totalPedidoPagamento += $itemPedido->total;
                        $itemPedido->idPedido = $modelPedido->idPedido;

                        if ($itemPedido->verificaQtdEstProdutoPedido($itemPedido->idProduto,
                            $itemPedido->quantidade)
                        ) {


                            //Tenta salvar os itens do Pedido:
                            if ($itemPedido->save()) {
                                Insumo::atualizaQtdNoEstoqueInsert(
                                    $itemPedido->idProduto, $itemPedido->quantidade);

                            }
                        
                        } else {
                            $mensagem = "<b>Pedido não foi cadastrado com sucesso! </b>Quantidade dos insumos
                              do produto pedido ultrapassa a quantidade de insumos em estoque.";
                            $transaction->rollBack(); //desfaz alterações no BD
                            $itensInseridos = false;

                            break; //encerra o laço for
                        }
                    }
                    //alterirei aqui
                    if($modelPedido->idSituacaoAtual == Pedido::CONCLUIDO){
                        
                        $caixa = new Caixa();
                            $caixa = $caixa->getCaixaAberto(Yii::$app->user->getId());
                            
                            if ($caixa != null) {
                                $caixa = Caixa::findOne($caixa->idcaixa);
                                $caixa->valoremcaixa += $totalPedidoPagamento;
                                $caixa->valorapurado += $totalPedidoPagamento;
                                $caixa->valorlucro += number_format($caixa->calculaValorLucroPedido($modelPedido->idPedido), 2);
                            
                                if (!$caixa->save()) {
                                    $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                                    $transaction->rollBack(); //desfaz alterações no BD
                                    $itensInseridos = false;
                                    echo Json::encode(false);
                                }
                        }
                        //print_r($itemPedido);
                        //return $this->actionFinalizarPedido($formaPagamento, $idPedido);
                    }
                    //Testa se todos os itens foram inseridos (ou tudo ou nada):
                    if ($itensInseridos) {
                        $transaction->commit();

                        return $this->redirect(['view', 'id' => $modelPedido->idPedido,]);
                    }
                } else {
                    $mensagem = "Não foi possível salvar os dados do Pedido";
                }
            } catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar o Pedido";
            }
        }
//        } else {
        $modelPedido->idSituacaoAtual = Pedido::EM_ANDAMENTO;

        return $this->render('create', [
            'modelPedido' => $modelPedido,
            'situacaopedido' => $situacaopedido,
            'produtosVenda' => $produtosVenda,
            'itemPedido' => $itemPedido,
            'formasPagamento' => $formasPagamento,
            'mensagem' => $mensagem,
            'mesa' => $mesa,
        ]);
        // }
    }

    /**
     * Updates an existing Pedido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelPedido = $this->findModel($id);

        $mensagem = ""; //Informa ao usuário mensagens de erro na view

        $situacaopedido = ArrayHelper::map(
            Situacaopedido::find()->all()
            , 'idSituacaoPedido', 'titulo');

        $produtosVenda = ArrayHelper::map(
            Produto::find()->where(['isInsumo' => 0])->all(), 'idProduto', 'nome');

        $itensPedido = Itempedido::find()->where(['idPedido' => $id])->all();

        $formasPagamento = ArrayHelper::map(
            Formapagamento::find()->all(), 'idTipoPagamento', 'titulo');


        $antigaSituacao = $modelPedido->idSituacaoAtual;

        $historicoSituacao = Historicosituacao::findOne([$modelPedido->idPedido, $modelPedido->idSituacaoAtual,
            Yii::$app->getUser()->id]);

        $historicoSituacao = Historicosituacao::find()->where([
           'idPedido'=> $modelPedido->idPedido,
            'user_id'=>  Yii::$app->getUser()->id
        ])->orderBy('dataHora')->one();

        //Recebe todas as mesas registradas
        $mesa = ArrayHelper::map(Mesa::find()
            ->all(), 'idMesa', 'numeroDaMesa');

        if ($modelPedido->load(Yii::$app->request->post()) &&
            (count($itensPedido) > 0)
        ) {
            //Carrega demais modelos

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();

            try {
                //Tenta salvar um registro de Pedido:


                if ($modelPedido->save()) {
                    //Carrega os dados dos itens do Pedido:
                    $itemPedidoPost = (Yii::$app->request->post()['Itempedido']);

                    $itensInseridos = true;

                    for ($i = 0; $i < count($itensPedido); $i++) {
                        $itemPedido = Itempedido::find()->where(['idPedido' => $id,
                            'idProduto' => $itensPedido[$i]->idProduto])->one();
                        if ($itemPedido != null) {
                            $itemPedido->removerItemPedido();
                        }
                    }
                    //AQUI
                    for ($i = 0; $i < count($itemPedidoPost['idProduto']); $i++) {
                        $itemPedido = new Itempedido();

                        $itemPedido->idProduto = $itemPedidoPost['idProduto'][$i];

                        $itemPedido->quantidade = $itemPedidoPost['quantidade'][$i];

                        $produtoVenda = Produto::find()->where(['idProduto' => $itemPedido->idProduto])->one();

                        $itemPedido->total = floatval(
                            number_format(
                                $produtoVenda->valorVenda * $itemPedido->quantidade, 2));

                        $itemPedido->idPedido = $modelPedido->idPedido;
                        //Tenta salvar os itens do Pedido:

                        if ($itemPedido->verificaQtdEstProdutoPedido($itemPedido->idProduto,
                            $itemPedido->quantidade)
                        ) {

                            if ($itemPedido->save()) {
                                Insumo::atualizaQtdNoEstoqueInsert(
                                    $itemPedido->idProduto, $itemPedido->quantidade);

                            } else {
                                $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                                $transaction->rollBack(); //desfaz alterações no BD
                                $itensInseridos = false;
                                break; //encerra o laço for
                            }
                        } else {
                            $mensagem = "<b>Pedido não foi alterado com sucesso! </b>Quantidade dos insumos
                              do produto pedido ultrapassa a quantidade de insumos em estoque.";
                            $transaction->rollBack(); //desfaz alterações no BD
                            $itensInseridos = false;
                            break; //encerra o laço for
                        }
                    }

                    if ($antigaSituacao != $modelPedido->idSituacaoAtual ||
                        $historicoSituacao->user_id != Yii::$app->getUser()->id) {

                        $modelPedido->cadastrarNovaHistoricoSituacaoPedido(($modelPedido->idPedido),
                            ($modelPedido->idSituacaoAtual),
                            Yii::$app->getUser()->id);
                    }

                    //Testa se todos os itens foram inseridos (ou tudo ou nada):
                    if ($itensInseridos) {

                        $transaction->commit();

                        return $this->redirect(['view', 'id' => $modelPedido->idPedido]);
                    }
                } else {
                    $mensagem = "Não foi possível salvar os dados do Pedido";
                }
            } catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar o Pedido";
            }
        }
//        } else {

        return $this->render('update', [
            'modelPedido' => $modelPedido,
            'situacaopedido' => $situacaopedido,
            'produtosVenda' => $produtosVenda,
            'itemPedido' => $itensPedido,
            'formasPagamento' => $formasPagamento,
            'mensagem' => $mensagem,
            'mesa' => $mesa,
        ]);
    }

    /**
     * Deletes an existing Pedido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $itenspedido = Itempedido::find()->where(['idPedido' => $id])->all();

        foreach ($itenspedido as $p) {
            Insumo::atualizaQtdNoEstoqueDelete($p->idProduto, $p->quantidade);
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pedido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pedido the loaded modelPedido
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelPedido = Pedido::findOne($id)) !== null) {
            return $modelPedido;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Finaliza o pedido e informa a forma de pagamento
     * 
     */

    public function actionFinalizarPedido($formaPagamento, $idPedido)
    {

        if ($formaPagamento != null && $idPedido != null) {
            $pagamento = Pagamento::find()->where(['idPedido' => $idPedido])->one();
            if ($pagamento != null) {
                $pagamento->formapagamento_idTipoPagamento = $formaPagamento;

                //Inicia a transação:
                $transaction = \Yii::$app->db->beginTransaction();
                try {

                    $itensInseridos = true;

                    if ($pagamento->save()) {
                        $pedido = $this->findModel($idPedido);
                        if ($pedido != null) {
                            $situacaoPedido = Pedido::CONCLUIDO;

                            $pedido->idSituacaoAtual = $situacaoPedido;


//                            if ($pedido->save() && $pedido->mudarHistoricoSituacaoPedido(intval($pedido->idSituacaoAtual))) {
                            if ($pedido->save() &&
                                ($pedido->cadastrarNovaHistoricoSituacaoPedido(intval($pedido->idPedido),
                                    intval($pedido->idSituacaoAtual),
                                    Yii::$app->getUser()->id))
                            ) {
                                $caixa = new Caixa();
                                $caixa = $caixa->getCaixaAberto(Yii::$app->user->getId());
                                if ($caixa != null) {
                                    $caixa = Caixa::findOne($caixa->idcaixa);
                                    $caixa->valoremcaixa += $pedido->totalPedido;
                                    $caixa->valorapurado += $pedido->totalPedido;
                                    $caixa->valorlucro += number_format($caixa->calculaValorLucroPedido($pedido->idPedido), 2);
                                    if (!$caixa->save()) {
                                        $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                                        $transaction->rollBack(); //desfaz alterações no BD
                                        $itensInseridos = false;
                                        echo Json::encode(false);

                                    }
                                } else {
                                    $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                                    $transaction->rollBack(); //desfaz alterações no BD
                                    $itensInseridos = false;
                                    echo Json::encode('caixanull');
                                }


                            } else {
                                $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                                $transaction->rollBack(); //desfaz alterações no BD
                                $itensInseridos = false;
                                echo Json::encode(false);
                            }

                        } else {
                            $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                            $transaction->rollBack(); //desfaz alterações no BD
                            $itensInseridos = false;
                            echo Json::encode(false);
                        }

                    } else {
                        $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                        $transaction->rollBack(); //desfaz alterações no BD
                        $itensInseridos = false;
                        echo Json::encode(false);
                    }
                    //Testa se todos os itens foram inseridos (ou tudo ou nada):
                    if ($itensInseridos) {
                        $transaction->commit();
                        echo Json::encode($pedido->idSituacaoAtual);
                    }
                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    $mensagem = "Ocorreu uma falha inesperada ao tentar salvar o Pedido";
                }
            } else {
                echo Json::encode(false);
            }
        } else {
            echo Json::encode(false);
        }
    }

}
