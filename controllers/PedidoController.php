<?php

namespace app\controllers;

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
class PedidoController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
    public function actionIndex() {
        $searchModel = new PedidoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pedido model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pedido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Pedido();
        $situacaopedido = ArrayHelper::map(
                        Situacaopedido::find()->all()
                        , 'idSituacaoPedido', 'titulo');

        $produtosVenda = ArrayHelper::map(
                        Produto::find()->where(['isInsumo' => 0])->all(), 'idProduto', 'nome');

        $itemPedido = new Itempedido();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $itemPedidoPost = (Yii::$app->request->post()['Itempedido']);

            for ($i = 0; $i < count($itemPedidoPost['idProduto']); $i++) {
                $itemPedido = new Itempedido();
                $itemPedido->idProduto = $itemPedidoPost['idProduto'][$i];
                $itemPedido->quantidade = $itemPedidoPost['quantidade'][$i];
                $produtoVenda = Produto::find()->where(['idProduto' => $itemPedido->idProduto])->one();
                $itemPedido->total = floatval(
                        number_format(
                                $produtoVenda->valorVenda * $itemPedido->quantidade, 2));
                $itemPedido->idPedido = $model->idPedido;
                if ($itemPedido->save()) {
                    Insumo::atualizaQtdNoEstoqueInsert(
                            $itemPedido->idProduto, $itemPedido->quantidade);
                    if ((count($itemPedidoPost['idProduto']) - 1) == $i) {

                        return $this->redirect(['view', 'id' => $model->idPedido]);
                    }
                }
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'situacaopedido' => $situacaopedido,
                        'produtosVenda' => $produtosVenda,
                        'itemPedido' => $itemPedido,
                        'itemPedido' => $itemPedido,
            ]);
        }
    }

    /**
     * Updates an existing Pedido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $situacaopedido = ArrayHelper::map(
                        Situacaopedido::find()->all()
                        , 'idSituacaoPedido', 'titulo');

        $produtosVenda = ArrayHelper::map(
                        Produto::find()->where(['isInsumo' => 0])->all(), 'idProduto', 'nome');

        $itensPedido = Itempedido::find()->where(['idPedido' => $id])->all();

        $formasPagamento = ArrayHelper::map(
                        Formapagamento::find()->all(), 'idTipoPagamento', 'titulo');
        if ($model->load(Yii::$app->request->post()) && $model->save() &&
                (count($itensPedido) > 0)) {


            $itemPedidoPost = (Yii::$app->request->post()['Itempedido']);

            for ($i = 0; $i < count($itensPedido); $i++) {
                $itemPedido = Itempedido::find()->where(['idPedido' => $id,
                            'idProduto' => $itensPedido[$i]->idProduto])->one();
                if ($itemPedido != null) {
                    $itemPedido->removerItemPedido();
                }
            }
            for ($i = 0; $i < count($itemPedidoPost['idProduto']); $i++) {

                $itemPedido = new Itempedido();
                $itemPedido->idProduto = $itemPedidoPost['idProduto'][$i];
                $itemPedido->quantidade = $itemPedidoPost['quantidade'][$i];
                $produtoVenda = Produto::find()->where(['idProduto' => $itemPedido->idProduto])->one();
                $itemPedido->total = floatval(
                        number_format(
                                $produtoVenda->valorVenda * $itemPedido->quantidade, 2));
                $itemPedido->idPedido = $id;
                if ($itemPedido->save()) {
                    Insumo::atualizaQtdNoEstoqueInsert(
                            $itemPedido->idProduto, $itemPedido->quantidade);
                    if ((count($itemPedidoPost['idProduto']) - 1) == $i) {
                        return $this->redirect(['view', 'id' => $model->idPedido]);
                    }
                }
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'situacaopedido' => $situacaopedido,
                        'produtosVenda' => $produtosVenda,
                        'itemPedido' => $itensPedido,
                        'formasPagamento' => $formasPagamento,
            ]);
        }
    }

    /**
     * Deletes an existing Pedido model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

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
     * @return Pedido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Pedido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * Finaliza o pedido e informa a forma de pagamento
     * 
     */

    public function actionFinalizarPedido($formaPagamento, $idPedido) {
        if ($formaPagamento != null && $idPedido != null) {
            $pagamento = Pagamento::find()->where(['idPedido' => $idPedido])->one();
            if ($pagamento != null) {
                $pagamento->idTipoPagamento = $formaPagamento;
                if ($pagamento->save(false)) {
                    $pedido = $this->findModel($idPedido);
                    if ($pedido != null) {
                        $situacaoPedido = Situacaopedido::find()
                                ->where(['like', 'titulo', 'Concluído'])
                                ->one();
                        if ($situacaoPedido != null) {
                            $pedido->idSituacaoAtual = $situacaoPedido->idSituacaoPedido;
                            if ($pedido->save(false)) {
                                echo Json::encode( $pedido->idSituacaoAtual);
                            } else {
                                echo Json::encode(false);
                            }
                        } else {
                            echo Json::encode(false);
                        }
                    } else {
                        echo Json::encode(false);
                    }
                } else {
                    echo Json::encode(false);
                }
            } else {
                echo Json::encode(false);
            }
        } else {
            echo Json::encode(false);
        }
    }

}
