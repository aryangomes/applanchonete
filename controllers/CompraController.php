<?php

namespace app\controllers;

use Yii;
use app\models\Compra;
use app\models\CompraSearch;
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
            'model' => $this->findModel($id),
            'compraProdutos' => $compraProdutos,
        ]);
    }

    /**
     * Creates a new Compra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Compra();

        $mensagem = ""; //Informa ao usuário mensagens de erro na view

        $conta = new Conta();

        $compraProduto = new Compraproduto();

        $produtos = ArrayHelper::map(Produto::find()->all(),
            'idProduto', 'nome');

        if ((Yii::$app->request->post())) {

            $conta->tipoConta = 'contasapagar';

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                //Tenta salvar um registro :

                if ($conta->save()) {

                    $itensInseridos = true;

                    $model->idconta = $conta->idconta;
                    $model->dataCompra = Yii::$app->request->post()['Compra']['dataCompra'];
                    if ($model->save()) {
                        $compraprodutos = Yii::$app->request->post()['Compraproduto'];
                        $valorescompraprodutos = Yii::$app->request->post()['compraproduto-valorcompra-disp'];

                        for ($i = 0; $i < count($compraprodutos['idProduto']); $i++) {
                            $cp = new Compraproduto();
                            $cp->idCompra = $model->idconta;
                            $cp->idProduto = $compraprodutos['idProduto'][$i];
                            $cp->quantidade = $compraprodutos['quantidade'][$i];

                            if ($i <= 0) {
                                $cp->valorCompra = $compraprodutos['valorCompra'][0];
                            } else {
                                $cp->valorCompra = (substr($valorescompraprodutos[$i - 1], 4));
                            }

                            if (!$cp->save()) {
                                $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                                $transaction->rollBack(); //desfaz alterações no BD
                                $itensInseridos = false;
                                break; //encerra o laço for
                            }

                        }

                        if ($itensInseridos) {
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->idconta]);
                        }

                    } else {
                        $transaction->rollBack();
                        $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
                    }


                }
            } catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
            }
//        } else {

        }
        $model->dataCompra = date('Y-m-d');

        return $this->render('create', [
            'model' => $model,
            'compraProduto' => $compraProduto,
            'produtos' => $produtos,
            'mensagem' => $mensagem,
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
        $model = $this->findModel($id);

        $mensagem = ""; //Informa ao usuário mensagens de erro na view

        $compraProduto = new Compraproduto();

        $produtos = ArrayHelper::map(Produto::find()->all(),
            'idProduto', 'nome');

        $produtosDaCompras =
            Compraproduto::find()->where(['idCompra' => $id])->all();




        if (Yii::$app->request->post()) {

            $itensInseridos = true;

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {

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
                    $cp->valorCompra = $compraProdutoAux['valorCompra'][$i];

                    if (!$cp->save()) {
                        $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                        $transaction->rollBack(); //desfaz alterações no BD
                        $itensInseridos = false;
                        break; //encerra o laço for
                    }

                }

                if ($itensInseridos) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->idconta]);
                }

            } catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
            }
        }

        return $this->render('update', [
            'model' => $model,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Compra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Compra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compra::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
