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
        $listadeinsumos = $searchModel->searchInsumos($id);

        $insumos = array();
        $produtoVenda = $this->findModel($id);

        foreach ($listadeinsumos as $insumo) {
            array_push($insumos,
                $insumo);

        }


        return $this->render('view', [
            'model' => $this->findModel($id),
            'insumos' => $insumos,
            'produtoVenda' => $produtoVenda,
        ]);
    }

    public function actionListadeinsumos()
    {
        $model = new Produto();
        $produtosVenda = ArrayHelper::map(
            Produto::find()->join('INNER JOIN', 'insumo', 'idProduto = idprodutoVenda ')
                ->where(['isInsumo' => 0])->all(),
            'idProduto', 'nome');
        if ((Yii::$app->request->post())) {
            $searchModel = new ProdutoSearch();

            $listadeinsumos = $searchModel->searchInsumos(Yii::$app->request->post());

            $insumos = array();
            $produtoVenda = $this->findModel(Yii::$app->request->post()['produtovenda']);
            foreach ($listadeinsumos as $insumo) {
                array_push($insumos,
                    $model::findOne($insumo->idprodutoInsumo));
            }

            return $this->render('listadeinsumos', [
                'insumos' => $insumos,
                'produtosVenda' => $produtosVenda,
                'produtoVenda' => $produtoVenda,
            ]);
        } else {

            return $this->render('listadeinsumos', [
                'produtosVenda' => $produtosVenda,

            ]);
        }
    }


    public function actionListadeprodutosporinsumo()
    {
        $model = new Produto();
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
                    $model::findOne($pv->idprodutoVenda));
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
        $model = new Produto();
        $insumo = new Insumo();
        $categorias = ArrayHelper::map(
            Categoria::find()->all(),
            'idCategoria', 'nome');
        $insumos = ArrayHelper::map(
            Produto::find()->where(['isInsumo' => 1])->all(),
            'idProduto', 'nome');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

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
                            ':idprodutoVenda' => $model->idProduto,
                            ':idprodutoInsumo' => $aux['idprodutoInsumo'][$i],
                            ':quantidade' => $aux['quantidade'][$i],
                            ':unidade' => $aux['unidade'][$i],
                        ])->execute();
                    }

                }
            }

            return $this->redirect(['view', 'id' => $model->idProduto]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categorias' => $categorias,
                'insumos' => $insumos,
                'insumo' => $insumo,
            ]);
        }
    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $insumo = new Insumo();
        $categorias = ArrayHelper::map(
            Categoria::find()->all(),
            'idCategoria', 'nome');
        if(!$model->isInsumo){
            $insumos = ArrayHelper::map(
                Produto::find()->where(['isInsumo' => 1])->all(),
                'idProduto', 'nome');
            $models = Insumo::find()->where(['idprodutoVenda' => $id])->all();

            $modelProdutoVenda = $this::findModel($id);
        }
        if ((Yii::$app->request->post())) {
            if(!$model->isInsumo) {
                if (isset(Yii::$app->request->post()['produto-valorvenda-disp'])){
                    $model->valorVenda =  Yii::$app->request->post()['Produto']['valorVenda'];
                    $model->idCategoria =  Yii::$app->request->post()['Produto']['idCategoria'];
                    $model->save();
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
            }else{
                $model->load(Yii::$app->request->post());
                $model->save();
            }
            return $this->redirect(['produto/view', 'id' => $id]);

        } else {
            if(!$model->isInsumo) {
                return $this->render('update', [
                    'model' => $model,
                    'models' => $models,
                    'categorias' => $categorias,
                    'insumos' => $insumos,
                    'insumo' => $insumo,
                    'modelProdutoVenda' => $modelProdutoVenda,

                    'idprodutoVenda' => $id,
                ]);
            }
            return $this->render('update', [
                'model' => $model,

                'categorias' => $categorias,

            ]);
        }
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

    public function actionAvaliacaoproduto($idproduto)
    {
        $model = $this->findModel($idproduto);
        if (Yii::$app->request->post()) {
            // var_dump(Yii::$app->request->post());
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
               ->groupBy('periodo');

           $qtdvendas = array();
           $datasvendas = array();
//var_dump($vendas->all());
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
               'datainicioavaliacao' => date('d/m/Y', strtotime($datainicioavaliacao)),
               'datafimavaliacao' => date('d/m/Y', strtotime($datafimavaliacao)),
               'model' => $model,

           ]);
        } else {
            return $this->render('avaliacaoproduto', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionAlterarprodutovenda($idprodutoVenda)
    {
        $model = new Insumo();//::findOne(['idprodutoVenda' => $idprodutoVenda, 'idprodutoInsumo' => $idprodutoInsumo]);
        $models = Insumo::find()->where(['idprodutoVenda' => $idprodutoVenda])->all();

        $modelProdutoVenda = $this::findModel($idprodutoVenda);
        $produtosvenda = ArrayHelper::map(
            Produto::findBySql('select * from produto where isInsumo = 0 and  idProduto not in (
            SELECT idProduto FROM produto RIGHT OUTER join  insumo on idprodutoVenda = idProduto)')->all(),
            'idProduto', 'nome');
        $insumos = ArrayHelper::map(
            Produto::find()->where(['isInsumo' => 1])->all(),
            'idProduto', 'nome');

        $settings = Insumo::find()->indexBy('idprodutoVenda')->all();

        //if (Insumos::loadMultiple($settings, Yii::$app->request->post())){
        if ($model->load(Yii::$app->request->post())) {

            // var_dump(Yii::$app->request->post());
            //  var_dump(Yii::$app->request->post('Insumos')['$i']['quantidade']);
            //  var_dump(Yii::$app->request->post('Insumos'));
            $aux = Yii::$app->request->post()['Insumo'];

            $n = count($aux['idprodutoInsumo']);
            // echo $n;
            Yii::$app->db->createCommand(
                "DELETE FROM insumo WHERE idprodutoVenda = :idprodutoVenda", [
                ':idprodutoVenda' => $idprodutoVenda,
            ])->execute();
            for ($i = 0; $i < $n; $i++) {
                /*     echo "idprodutoVenda.:" . $aux['idprodutoVenda'];
                   echo "</br>";
                   echo "idprodutoInsumo.:" . $aux['idprodutoInsumo'][$i];
                   echo "</br>";
                   echo "quantidade.:" . $aux['quantidade'][$i];
                   echo "</br>";
                   echo "unidade.:" . $aux['unidade'][$i];
                   echo "</br>";
                   echo "</br>";*/
                //  var_dump($aux['quantidade'][$i]);
                if (($aux['idprodutoInsumo'][$i]) > 0) {

                    Yii::$app->db->createCommand(
                        "INSERT INTO insumo
                    (idprodutoVenda, idprodutoInsumo,
                      quantidade,unidade ) 
                  VALUES (:idprodutoVenda, :idprodutoInsumo,
                    :quantidade,:unidade)", [
                        ':idprodutoVenda' => $idprodutoVenda,
                        ':idprodutoInsumo' => $aux['idprodutoInsumo'][$i],
                        ':quantidade' => $aux['quantidade'][$i],
                        ':unidade' => $aux['unidade'][$i],
                    ])->execute();
                }
                /* $model->idprodutoInsumo = $aux['idprodutoInsumo'][$i];
                  $model->idprodutoVenda = $aux['idprodutoVenda'];
                  $model->quantidade = $aux['quantidade'][$i];
                  $model->unidade = $aux['unidade'][$i];
                  $model->save(false);
               */
            }

            return $this->redirect(['produto/view', 'id' => $idprodutoVenda]);

            // return $this->redirect(['view', 'idprodutoVenda' => $model->idprodutoVenda, 'idprodutoInsumo' => $model->idprodutoInsumo]);
        } else {

            //Para modificar acesse o /views/insumos/_form.php
            return $this->render('/produto/alterarprodutovenda', [
                'models' => $models,
                'modelProdutoVenda' => $modelProdutoVenda,
                'insumos' => $insumos,
                'produtosvenda' => $produtosvenda,
                'idprodutoVenda' => $idprodutoVenda,
            ]);
        }

    }
}