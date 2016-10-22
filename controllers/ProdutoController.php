<?php

namespace app\controllers;

use Yii;
use app\models\Produto;
use app\models\ProdutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Categoria;
use app\models\Insumo;
use app\models\Itempedido;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use app\components\AccessFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;

/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'produto' => [
                        'index-produto',
                        'update-produto',
                        'delete-produto',
                        'view-produto',
                        'create-produto',
                        'listadeinsumos',
                        'avaliacaoproduto',
                        'listadeprodutosporinsumo',
                        'produtosvenda',
                        'cadastrarprodutovenda',
                        'alterarprodutovenda',
                        'definirvalorprodutovenda',
                        'lucroproduto',
                        'cadastrarnovoproduto',
                    ],

                    'index' => 'index-produto',
                    'update' => 'update-produto',
                    'delete' => 'delete-produto',
                    'view' => 'view-produto',
                    'create' => 'create-produto',
                    'avaliacaoproduto' => 'avaliacaoproduto',
                    'listadeinsumos' => 'listadeinsumos',
                    'listadeprodutosporinsumo' => 'listadeprodutosporinsumo',
                    'produtosvenda' => 'produtosvenda',
                    'cadastrarprodutovenda' => 'cadastrarprodutovenda',
                    'alterarprodutovenda' => 'alterarprodutovenda',
                    'definirvalorprodutovenda' => 'definirvalorprodutovenda',
                    'lucroproduto' => 'lucroproduto',
                    'cadastrar-novo-produto' => 'produto',
                    'get-produto' => 'produto',
                    'get-produtos' => 'produto',

                ],
            ],
        ];
    }

    /**
     * Lists all Produto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProdutosvenda()
    {
        $searchModel = new ProdutoSearch();
        $dataProvider = $searchModel->searchProdutosVendaIndex(Yii::$app->request->queryParams);

        return $this->render('produtosvenda', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new ProdutoSearch();
        $modelProduto = $this->findModel($id);
        if ($modelProduto->isInsumo) {
            return $this->render('view', [
                'modelProduto' => $modelProduto,

            ]);

        } else {
            $listadeinsumos = $searchModel->searchInsumos($id);

            $insumos = array();
            $produtoVenda = $this->findModel($id);


            /**
             * Cria e adiciona os Insumos de um Produto Venda
             * em um array
             */
            foreach ($listadeinsumos as $insumo) {
                array_push($insumos,
                    $insumo);

            }


            return $this->render('view', [
                'modelProduto' => $modelProduto,
                'insumos' => $insumos,
                'produtoVenda' => $produtoVenda,
            ]);
        }
    }

    /**
     * Retorna a lista de Insumos de um Produto Venda
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionListadeinsumos()
    {
        $modelProduto = new Produto();
        $produtosVenda = ArrayHelper::map(
            Produto::find()->join('INNER JOIN', 'insumo', 'idProduto = idprodutoVenda ')
                ->where(['isInsumo' => 0])->all(),
            'idProduto', 'nome');
        if ((Yii::$app->request->post())) {
            $searchModel = new ProdutoSearch();

            $listadeinsumos = $searchModel->searchInsumos(Yii::$app->request->post());

            $insumos = array();
            $modelProduto = $this->findModel(Yii::$app->request->post()['produtovenda']);
            foreach ($listadeinsumos as $insumo) {
                array_push($insumos,
                    $modelProduto::findOne($insumo->idprodutoInsumo));
            }

            return $this->render('listadeinsumos', [
                'insumos' => $insumos,
                'produtosVenda' => $produtosVenda,
                'modelProduto' => $modelProduto,
            ]);
        } else {

            return $this->render('listadeinsumos', [
                'produtosVenda' => $produtosVenda,

            ]);
        }
    }

    /**
     * Retorna a lista de Produtos Venda que possuem um determinado Insumo
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionListadeprodutosporinsumo()
    {
        $modelProduto = new Produto();

        $insumos = ArrayHelper::map(
            Produto::find()->join('INNER JOIN', 'insumo', 'idProduto = idprodutoInsumo ')
                ->where(['isInsumo' => 1])->all(),
            'idProduto', 'nome');

        if ((Yii::$app->request->post())) {
            $searchModel = new ProdutoSearch();

            $listadeprodutosvenda = $searchModel->searchProdutosVenda(Yii::$app->request->post());

            $nomeInsumo = $this->findModel(Yii::$app->request->post()['idinsumo'])->nome;


            $produtosVenda = array();

            foreach ($listadeprodutosvenda as $pv) {
                array_push($produtosVenda,
                    $modelProduto::findOne($pv->idprodutoVenda));
            }

            return $this->render('listadeprodutosporinsumo', [
                'insumos' => $insumos,
                'produtosVenda' => $produtosVenda,
                'nomeInsumo' => $nomeInsumo,
            ]);
        } else {

            return $this->render('listadeprodutosporinsumo', [
                'insumos' => $insumos,

            ]);
        }
    }


    /**
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelProduto = new Produto();

        $mensagem = ""; //Informa ao usuário mensagens de erro na view


        $modelInsumo = new Insumo();

        $categorias = ArrayHelper::map(
            Categoria::find()->all(),
            'idCategoria', 'nome');

        $insumos = ArrayHelper::map(
            Produto::find()->where(['isInsumo' => 1])->all(),
            'idProduto', 'nome');

        if ($modelProduto->load(Yii::$app->request->post())) {
            //Faz o upload da image
            $modelProduto->imageFile = UploadedFile::getInstance($modelProduto, 'imageFile');
            if (isset($modelProduto->imageFile)) {

                //Converte a imagem em binário
                $modelProduto->foto = file_get_contents($modelProduto->imageFile->tempName);
            }
            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                //Tenta salvar um registro :

                if ($modelProduto->save()) {

                    $itensInseridos = true;

                    if (!Yii::$app->request->post()['Produto']['isInsumo']) {
                        $aux = Yii::$app->request->post()['Insumo'];
                        $n = count($aux['idprodutoInsumo']);

                        for ($i = 0; $i < $n; $i++) {

                            if (($aux['idprodutoInsumo'][$i]) > 0) {


                                Yii::$app->db->createCommand(
                                    "INSERT INTO insumo
                    (idprodutoVenda, idprodutoInsumo,
                      quantidade,unidade ) 
                  VALUES (:idprodutoVenda, :idprodutoInsumo,
                    :quantidade,:unidade)", [
                                    ':idprodutoVenda' => $modelProduto->idProduto,
                                    ':idprodutoInsumo' => $aux['idprodutoInsumo'][$i],
                                    ':quantidade' => $aux['quantidade'][$i],
                                    ':unidade' => $aux['unidade'][$i],
                                ])->execute();
                            }

                        }

                        $modelProduto->valorVenda = $modelProduto->calculoPrecoProduto($modelProduto->idProduto);
                        if (!$modelProduto->save()) {
                            $mensagem = "Não foi possível salvar os dados";
                            $transaction->rollBack(); //desfaz alterações no BD
                            $itensInseridos = false;
                        }
                        if ($itensInseridos) {
                            $transaction->commit();
                            return $this->redirect(['definirvalorprodutovenda', 'idProduto' => $modelProduto->idProduto]);
                        }
                    }
                    if ($itensInseridos) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelProduto->idProduto]);
                    }


                }
            } catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
            }
        }

        return $this->render('create', [
            'modelProduto' => $modelProduto,
            'categorias' => $categorias,
            'insumos' => $insumos,
            'modelInsumo' => $modelInsumo,
            'mensagem' => $mensagem,
        ]);
    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $modelProduto = $this->findModel($id);

        $modelInsumo = new Insumo();

        $mensagem = ""; //Informa ao usuário mensagens de erro na view

        $categorias = ArrayHelper::map(
            Categoria::find()->all(),
            'idCategoria', 'nome');

        if (!$modelProduto->isInsumo) {
            $insumos = ArrayHelper::map(
                Produto::find()->where(['isInsumo' => 1])->all(),
                'idProduto', 'nome');

            $modelsInsumos = Insumo::find()->where(['idprodutoVenda' => $id])->all();

            $modelProdutoVenda = $this::findModel($id);
        }

        if ((Yii::$app->request->post())) {

            //Inicia a transação:
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                //Tenta salvar um registro :

                $itensInseridos = true;

                $modelProduto->imageFile = UploadedFile::getInstance($modelProduto, 'imageFile');
                if (isset($modelProduto->imageFile)) {

                    //Converte a imagem em binário
                    $modelProduto->foto = file_get_contents($modelProduto->imageFile->tempName);
                }


                if (!$modelProduto->isInsumo) {
                    if (isset(Yii::$app->request->post()['produto-valorvenda-disp'])) {
                        $modelProduto->valorVenda = Yii::$app->request->post()['Produto']['valorVenda'];
                        $modelProduto->idCategoria = Yii::$app->request->post()['Produto']['idCategoria'];
                        $modelProduto->save();
                    }
                    $aux = Yii::$app->request->post()['Insumo'];

                    $n = count($aux['idprodutoInsumo']);

                    Yii::$app->db->createCommand(
                        "DELETE FROM insumo WHERE idprodutoVenda = :idprodutoVenda", [
                        ':idprodutoVenda' => $id,
                    ])->execute();
                    for ($i = 0; $i < $n; $i++) {

                        if (($aux['idprodutoInsumo'][$i]) > 0) {

                            Yii::$app->db->createCommand(
                                "INSERT INTO insumo
                    (idprodutoVenda, idprodutoInsumo,
                      quantidade,unidade ) 
                  VALUES (:idprodutoVenda, :idprodutoInsumo,
                    :quantidade,:unidade)", [
                                ':idprodutoVenda' => $id,
                                ':idprodutoInsumo' => $aux['idprodutoInsumo'][$i],
                                ':quantidade' => $aux['quantidade'][$i],
                                ':unidade' => $aux['unidade'][$i],
                            ])->execute();
                        }

                    }
                    $modelProduto->valorVenda = $modelProduto->calculoPrecoProduto($modelProduto->idProduto);
                    if (!$modelProduto->save()) {
                        $mensagem = "Não foi possível salvar os dados";
                        $transaction->rollBack(); //desfaz alterações no BD
                        $itensInseridos = false;
                    }
                } else {
                    $modelProduto->load(Yii::$app->request->post());
                    if (!$modelProduto->save()) {
                        $mensagem = "Não foi possível salvar os dados";
                        $transaction->rollBack(); //desfaz alterações no BD
                        $itensInseridos = false;
                    }
                }
                if ($itensInseridos) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $modelProduto->idProduto]);
                }

            } catch (\Exception $exception) {
                $transaction->rollBack();
                $mensagem = "Ocorreu uma falha inesperada ao tentar salvar ";
            }


        }

        $modelProduto->quantidadeEstoque = 0;
        $modelProduto->quantidadeMinima = 0;
        if (!$modelProduto->isInsumo) {
            return $this->render('update', [
                'modelProduto' => $modelProduto,
                'modelsInsumos' => $modelsInsumos,
                'categorias' => $categorias,
                'insumos' => $insumos,
                'insumo' => $modelInsumo,
                'modelProdutoVenda' => $modelProdutoVenda,
                'mensagem' => $mensagem,
                'idprodutoVenda' => $id,
            ]);
        }
        return $this->render('update', [
            'modelProduto' => $modelProduto,
            'mensagem' => $mensagem,
            'categorias' => $categorias,

        ]);
    }


    /**
     * Deletes an existing Produto model.
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
     * Gera um gráfico com as vendas de um Produto Venda
     * @param $idproduto
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionAvaliacaoproduto($idproduto)
    {
        $modelProduto = $this->findModel($idproduto);
        if (Yii::$app->request->post()) {

            $groupbyavaliacao = Yii::$app->request->post()['Produto']['groupbyavaliacao'];
            $datainicioavaliacao = Yii::$app->request->post()['datainicioavaliacao'];
            $datafimavaliacao = Yii::$app->request->post()['datafimavaliacao'];

            switch ($groupbyavaliacao) {
                case 'DAY':
                    $formatdate = 'd';
                    break;

                case 'MONTH':
                    $formatdate = 'm';
                    break;

                case 'YEAR':
                    $formatdate = 'Y';
                    break;
                default:
                    $formatdate = 'd';
                    break;
            }

            $vendas = Itempedido::find();

            $vendas
                ->select('*, sum(quantidade) as total, ' . $groupbyavaliacao . '(dataHora) as periodo')
                ->joinWith('produto')
                ->joinWith('pedido.pagamento.contasareceber.conta')
                ->andFilterWhere(['produto.idProduto' => $idproduto,])
                ->andFilterWhere(['>=', 'dataHora', $datainicioavaliacao])
                ->andFilterWhere(['<=', 'dataHora', $datafimavaliacao])
                ->groupBy('periodo')
                ->orderBy('dataHora ASC');

            $qtdvendas = array();
            $datasvendas = array();

            foreach ($vendas->all() as $key => $v) {
                array_push($qtdvendas, intval($v->total));
                if ($formatdate == 'm') {
                    array_push($datasvendas, Yii::t('app', date('F',
                        strtotime($v->pedido->pagamento->contasareceber->dataHora))));

                } elseif ($formatdate == 'Y') {
                    array_push($datasvendas, date('Y',
                        strtotime($v->pedido->pagamento->contasareceber->dataHora)));

                } else {
                    array_push($datasvendas, date('d/m/Y',
                        strtotime($v->pedido->pagamento->contasareceber->dataHora)));
                }
            }


            return $this->render('avaliacaoproduto', [
                'qtdvendas' => $qtdvendas,
                'datasvendas' => $datasvendas,
                'datainicio' => ($datainicioavaliacao),
                'datafim' => ($datafimavaliacao),
                'datainicioavaliacao' => date('d/m/Y', strtotime($datainicioavaliacao)),
                'datafimavaliacao' => date('d/m/Y', strtotime($datafimavaliacao)),
                'modelProduto' => $modelProduto,

            ]);
        } else {
            return $this->render('avaliacaoproduto', [
                'modelProduto' => $modelProduto,
            ]);
        }
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Produto the loaded modelProduto
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($modelProduto = Produto::findOne($id)) !== null) {
            return $modelProduto;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    /**
     * @param $idProduto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDefinirvalorprodutovenda($idProduto)
    {

        $modelProduto = $this->findModel($idProduto);
        if (Yii::$app->request->post()) {
            $porcentagemLucro = (Yii::$app->request->post()['porcentagemLucro']);
            $modelProduto->valorVenda = $modelProduto->calculoPrecoProduto($idProduto)
                + ($modelProduto->calculoPrecoProduto($idProduto) * ($porcentagemLucro / 100));
            if ($modelProduto->save()) {
                return $this->redirect(['view', 'id' => $modelProduto->idProduto]);
            }
        } else {
            return $this->render('definirvalorprodutovenda', [
                'modelProduto' => $modelProduto,
            ]);
        }
    }


    /**
     * Recupera um produto pelo nome
     * @param $busca
     */
    public function actionGetProdutos($busca)
    {
        $buscaProdutos = Produto::find()
            ->where(['like', 'nome', $busca])->all();/*ArrayHelper::map(
            Produto::find()
                ->where(['like','nome',$busca])
                ->all(),
            'idProduto','nome'
        );*/

        if ($buscaProdutos != null) {
            $produtos = [];
            foreach ($buscaProdutos as $p) {
                array_push($produtos, $p);
            }
            echo Json::encode($produtos);
        } else {
            echo Json::encode(null);
        }


    }

    /**
     * Recupera todos os produtos
     */
    public function actionGetProduto()
    {
        $produtos = ArrayHelper::map(Produto::find()->all(),
            'nome', 'idProduto');
        echo Json::encode($produtos);


    }

    /**
     * Cadastra um novo produto
     * @param null $nome
     * @param null $categoria
     * @param null $estoqueMinimo
     */
    public function actionCadastrarNovoProduto($nome = null,
                                               $categoria = null,
                                               $estoqueMinimo = null)
    {

        if ($nome != null && $categoria != null && $estoqueMinimo != null) {
            $novoProduto = new Produto();
            $novoProduto->nome = $nome;
            $novoProduto->idCategoria = $categoria;
            $novoProduto->quantidadeMinima = $estoqueMinimo;
            $novoProduto->quantidadeEstoque = 0;
            $novoProduto->isInsumo = 1;

            if ($novoProduto->save()) {
                echo Json::encode(true);
            } else {
                echo Json::encode(false);
            }
        } else {
            echo Json::encode(false);
        }


    }



}