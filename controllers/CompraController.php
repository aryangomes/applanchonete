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

        //Recebe o valor total da compra
        $valorTotalDaCompra = 0;

        //Setando o fuso horário
        date_default_timezone_set('America/Sao_Paulo');

        if ((Yii::$app->request->post())) {

            $conta->tipoConta = 'contasapagar';

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                //Tenta salvar um registro :

                if ($conta->save(false)) {

                    $itensInseridos = true;

                    $model->idconta = $conta->idconta;
                    $model->dataCompra = Yii::$app->request->post()['Compra']['dataCompra'];
                    if ($model->save(false)) {
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
                                $cp->valorCompra = (($valorescompraprodutos[$i - 1]));
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

                        $model->valor = $valorTotalDaCompra;

                        if (!$model->save(false)) {
                            $mensagem = "Não foi possível salvar os dados ";
                            $transaction->rollBack(); //desfaz alterações no BD
                            $itensInseridos = false;
                        }else{
                            $conta->valor= $model->valor;
                            if (!$conta->save(false)) {
                                $mensagem = "Não foi possível salvar os dados ";
                                $transaction->rollBack(); //desfaz alterações no BD
                                $itensInseridos = false;
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


                } else {
                    $transaction->rollBack();
                    $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
                }
            } catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
            }


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

        $conta = Conta::findOne($model->idconta);

        $mensagem = ""; //Informa ao usuário mensagens de erro na view

        $compraProduto = new Compraproduto();

        $produtos = ArrayHelper::map(Produto::find()->all(),
            'idProduto', 'nome');

        $produtosDaCompras =
            Compraproduto::find()->where(['idCompra' => $id])->all();


        //Recebe o valor total da compra
        $valorTotalDaCompra = 0;



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

                        $cp->valorCompra = (Yii::$app->request->post()
                        ['compraproduto-valorcompra-disp'][$i]);



                    if (!$cp->save(false)) {
                        $mensagem = "Não foi possível salvar os dados de algum";
                        $transaction->rollBack(); //desfaz alterações no BD
                        $itensInseridos = false;
                        break; //encerra o laço for
                    } else {

                        $valorTotalDaCompra += floatval($cp->valorCompra);

                    }

                }

                $model->valor = $valorTotalDaCompra;



                if (!$model->save(false)) {
                    $mensagem = "Não foi possível salvar os dados ";
                    $transaction->rollBack(); //desfaz alterações no BD
                    $itensInseridos = false;
                }else{
                    $conta->valor= $model->valor;
                    if (!$conta->save(false)) {
                        $mensagem = "Não foi possível salvar os dados ";
                        $transaction->rollBack(); //desfaz alterações no BD
                        $itensInseridos = false;
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

        //Inicia a transação:
        $transaction = \Yii::$app->db->beginTransaction();
        try {

            $itensDeletados = true;

            $produtosCompra = Compraproduto::find()
                ->where(['idCompra'=>$id])->all();

            foreach ($produtosCompra as $pc){

                    $produto = Produto::findOne($pc->idProduto);

                    $produto->quantidadeEstoque -= $pc->quantidade;

                if(!$produto->save()){
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

        return $this->redirect(['view', 'id' => $id]);

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
