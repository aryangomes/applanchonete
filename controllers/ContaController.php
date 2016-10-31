<?php

namespace app\controllers;

use app\models\Custofixo;
use app\models\Insumo;
use app\models\Tipocustofixo;
use Yii;
use app\models\Conta;
use app\models\ContaSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Contasapagar;
use app\models\Contasareceber;
use app\components\AccessFilter;
use app\models\Itempedido;
use app\models\Pagamento;
use app\models\Insumos;

/**
 * ContaController implements the CRUD actions for Conta model.
 */
class ContaController extends Controller
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

                    'conta' => [
                        'index-conta',
                        'update-conta',
                        'delete-conta',
                        'view-conta',
                        'create-conta',
                    ],

                    'index' => 'index-conta',
                    'update' => 'update-conta',
                    'delete' => 'delete-conta',
                    'view' => 'view-conta',
                    'create' => 'create-conta',
                ],
            ],
        ];
    }

    /**
     * Lists all Conta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Conta model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'modelConta' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Conta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //Setando para o fuso horário do Brasil
        date_default_timezone_set('America/Sao_Paulo');


        $modelConta = new Conta();

        $mensagem = ""; //Informa ao usuário mensagens de erro na view

        $modelContaapagar = new Contasapagar();

        $modelContasareceber = new Contasareceber();

        $modelCustofixo = new Custofixo();

        $tiposConta = ['contasapagar' => 'Conta a pagar', 'contasareceber' => 'Conta a receber',
            'custofixo' => 'Custo Fixo'];

        $tiposCustoFixo = ArrayHelper::map(Tipocustofixo::find()->all(),
            'idtipocustofixo', 'tipocustofixo');
//       
        if ($modelConta->load(Yii::$app->request->post())) {

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                //Tenta salvar um registro :

                if ($modelConta->save()) {

                    $itemInserido = true;

                    $conta = Yii::$app->request->post()['Conta'];

                    $contasapagar = Yii::$app->request->post()['Contasapagar'];
                    $contasareceber = Yii::$app->request->post()['Contasareceber'];
                    $custofixo = Yii::$app->request->post()['Custofixo'];
                    if ($conta['tipoConta'] == 'contasapagar') {
                        $modelContaapagar->idconta = $modelConta->idconta;
//                        $modelContaapagar->situacaoPagamento = $contasapagar['situacaoPagamento'];
                        $modelContaapagar->dataVencimento = $contasapagar['dataVencimento'];
                        if (!$modelContaapagar->save()) {
                            $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                            $transaction->rollBack(); //desfaz alterações no BD
                            $itemInserido = false;
                        }

                    } else if ($conta['tipoConta'] == 'contasareceber') {
                        $modelContasareceber->idconta = $modelConta->idconta;
                        if (($contasareceber['dataHora']) != null) {
                            $modelContasareceber->dataHora = $contasareceber['dataHora'];
                            if (!$modelContasareceber->save()) {
                                $mensagem = "Não foi possível salvar os dados";
                                $transaction->rollBack(); //desfaz alterações no BD
                                $itemInserido = false;
                            }

                        }

                    } else if ($conta['tipoConta'] == 'custofixo') {

                        $modelCustofixo->idconta = $modelConta->idconta;
                        $modelContaContaapagar->idconta = $modelConta->idconta;
                        $modelContaContaapagar->dataVencimento = $contasapagar['dataVencimento'];
                        $modelContaCustofixo->consumo = $custofixo['consumo'];
                        $modelCustofixo->tipocustofixo_idtipocustofixo = $custofixo['tipocustofixo_idtipocustofixo'];
                        if ($modelContaapagar->save()) {

                            if (!$modelCustofixo->save()) {
                                $mensagem = "Não foi possível salvar os dados ";
                                $transaction->rollBack(); //desfaz alterações no BD
                                $itemInserido = false;
                            }
                        } else {
                            $mensagem = "Não foi possível salvar os dados";
                            $transaction->rollBack(); //desfaz alterações no BD
                            $itemInserido = false;
                        }


                    }

                    if ($itemInserido) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelConta->idconta]);
                    }

                }
            } catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
            }


        }

        $modelContasareceber->dataHora = date('Y-m-d H:i:s');
        return $this->render('create', [
            'modelConta' => $modelConta,
            'tiposConta' => $tiposConta,
            'modelContaapagar' => $modelContaapagar,
            'modelContasareceber' => $modelContasareceber,
            'modelCustofixo' => $modelCustofixo,
            'tiposCustoFixo' => $tiposCustoFixo,
            'mensagem' => $mensagem,
        ]);
    }

    /**
     * Updates an existing Conta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public
    function actionUpdate($id)
    {
        $modelConta = $this->findModel($id);

        //Guarda o tipo de conta
        $tipodeConta = $modelConta->tipoConta;

        $mensagem = ""; //Informa ao usuário mensagens de erro na view


        $tiposConta = ['contasapagar' => 'Conta a pagar', 'contasareceber' => 'Conta a receber',
            'custofixo' => 'Custo Fixo'];

        if (Contasapagar::findOne($id)) {
            $modelContaapagar = Contasapagar::findOne($id);
        } else {
            $modelContaapagar = new Contasapagar();
        }

        if (Contasareceber::findOne($id)) {
            $modelContasareceber = Contasareceber::findOne($id);
        } else {
            $modelContasareceber = new Contasareceber();
        }

        if (Custofixo::findOne($id)) {
            $modelCustofixo = Custofixo::findOne($id);
        } else {
            $modelCustofixo = new Custofixo();
        }

        $tiposCustoFixo = ArrayHelper::map(Tipocustofixo::find()->all(),
            'idtipocustofixo', 'tipocustofixo');


        if ($modelConta->load(Yii::$app->request->post())) {

            $modelConta->tipoConta = $tipodeConta;

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {


                //Tenta salvar um registro :

                if ($modelConta->save()) {
                    $itemInserido = true;

                    $conta = Yii::$app->request->post()['Conta'];

                    $contasapagar = Yii::$app->request->post()['Contasapagar'];
                    $contasareceber = Yii::$app->request->post()['Contasareceber'];
                    $custofixo = Yii::$app->request->post()['Custofixo'];
                    if ($conta['tipoConta'] == 'contasapagar') {
                        $modelContaapagar->idconta = $modelConta->idconta;
//                        $modelContaapagar->situacaoPagamento = $contasapagar['situacaoPagamento'];
                        $modelContaapagar->dataVencimento = $contasapagar['dataVencimento'];
                        if (!$modelContaapagar->save()) {
                            $mensagem = "Não foi possível salvar os dados de algum item do Pedido";
                            $transaction->rollBack(); //desfaz alterações no BD
                            $itemInserido = false;
                        }

                    } else if ($conta['tipoConta'] == 'contasareceber') {
                        $modelContasareceber->idconta = $modelConta->idconta;
                        if (($contasareceber['dataHora']) != null) {
                            $modelContasareceber->dataHora = $contasareceber['dataHora'];
                            if (!$modelContasareceber->save()) {
                                $mensagem = "Não foi possível salvar os dados";
                                $transaction->rollBack(); //desfaz alterações no BD
                                $itemInserido = false;
                            }

                        }

                    } else if ($conta['tipoConta'] == 'custofixo') {

                        $modelCustofixo->idconta = $modelConta->idconta;
                        $modelContaapagar->idconta = $modelConta->idconta;
                        $modelContaapagar->dataVencimento = $contasapagar['dataVencimento'];
                        $modelCustofixo->consumo = $custofixo['consumo'];
                        $modelCustofixo->tipocustofixo_idtipocustofixo = $custofixo['tipocustofixo_idtipocustofixo'];
                        if ($modelContaapagar->save()) {

                            if (!$modelCustofixo->save()) {
                                $mensagem = "Não foi possível salvar os dados ";
                                $transaction->rollBack(); //desfaz alterações no BD
                                $itemInserido = false;
                            }
                        } else {
                            $mensagem = "Não foi possível salvar os dados";
                            $transaction->rollBack(); //desfaz alterações no BD
                            $itemInserido = false;
                        }


                    }

                    if ($itemInserido) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelConta->idconta]);
                    }
                }
            } catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
            }


        }
        return $this->render('update', [
            'modelConta' => $modelConta,
            'tiposConta' => $tiposConta,
            'modelContaapagar' => $modelContaapagar,
            'modelContasareceber' => $modelContasareceber,
            'modelCustofixo' => $modelCustofixo,
            'tiposCustoFixo' => $tiposCustoFixo,
            'mensagem' => $mensagem,
        ]);
    }

    /**
     * Deletes an existing Conta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public
    function actionDelete($id)
    {


        //Guarda a mensagem
        $mensagem = "";

        $transaction = \Yii::$app->db->beginTransaction();
        try {

            $idpedido = Pagamento::find()->where(['idconta' => $id])->one();

            if (isset($idpedido)) {
                $itenspedido = Itempedido::find()->where(['idPedido' => $idpedido->idPedido])->all();

                foreach ($itenspedido as $p) {
                    Insumo::atualizaQtdNoEstoqueDelete($p->idProduto, $p->quantidade);
                }

            }

            if ($this->findModel($id)->delete()) {
                $transaction->commit();
            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
            $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
        }

        $searchModel = new ContaSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'mensagem' => $mensagem

        ]);


    }

    /**
     * Finds the Conta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($modelConta = Conta::findOne($id)) !== null) {
            return $modelConta;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
