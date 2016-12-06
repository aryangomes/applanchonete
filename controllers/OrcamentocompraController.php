<?php

namespace app\controllers;

use app\components\AccessFilter;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\OrcamentoCompra;

class OrcamentocompraController extends Controller
{

    public function behaviors()
    {
        return [
//            'access' => [
//        'class' => AccessControl::classname(),
//        'only'=> ['create','update','view','delete','index'],
//        'rules'=> [
//        ['allow'=>true,
//        'roles' => ['mesa','index-mesa'],
//        ],
//        ]
//        ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
//            ],
            'autorizacao' => [
                'class' => AccessFilter::className(),
                'actions' => [

                    'produto' => [
                        'orcamentocomprainsumos' => 'produto',
                    ],

                    'orcamentocomprainsumos' => 'produto',

                ],
            ],
        ];
    }

    public function actionOrcamentocomprainsumos()
    {
        $modelOrcamentoCompra = new OrcamentoCompra();
        $post = \Yii::$app->request->post();

        $listaInsumosCadastrados = Yii::$app->db->createCommand('SELECT idProduto, nome 
                FROM produto WHERE isInsumo = 1')->queryAll();
            $options = \yii\helpers\ArrayHelper::map($listaInsumosCadastrados, 'idProduto', 'nome');

            $totalProdutos = count($options);
            $produtosColuna = round($totalProdutos/3);

            $output1 = array_slice($options, 0, $produtosColuna, true);
            $output2 = array_slice($options, $produtosColuna, $produtosColuna, true);
            $output3 = array_slice($options, (($produtosColuna - 1)* -1), $produtosColuna, true);

        if ($modelOrcamentoCompra->load($post)) {
            
            // Recupera a lista de insumos que o usuário gostaria de ver o orçamento
            $modelOrcamentoCompra->listaInsumos = $post['OrcamentoCompra']['listaInsumos'];

            //Array que irá armazenar a lista de produtos vindos do banco que o usuário quer o orçamento
            $resultados = array();
<<<<<<<

=======
            $mensagem = "";
            $produtoSemPreco = false;
            
            //Varivel que irá guardar o valor total do orçamento
>>>>>>>
            $valororcamento = 0;

            //laço que irá percorrer todos os insumos selecionados pelo usuário e irá buscar
            // no banco de dados
            foreach ($modelOrcamentoCompra->listaInsumos as $lista) {
                
                // consulta a tabela Produto onde irá pegar todos os Produtos que o usuário quer no orçamento
                //$result = Yii::$app->db->createCommand('SELECT valorCompra FROM compraproduto 
                //    WHERE idProduto = :id', ['id' => $lista])->queryAll();

                $result = Yii::$app->db->createCommand('SELECT c.valorCompra, p.nome 
                    FROM compraproduto AS c, produto AS p WHERE c.idProduto = :id AND p.idProduto = :id ORDER BY idCompra DESC LIMIT 1', ['id' => $lista])->queryAll();


                if(empty($result) == false){
                    // adiciona cada produto recuperado dentro do um array de produtos
                    array_push($resultados, $result);
                    
                    //die();
                } else {
                    $nomeProduto = Yii::$app->db->createCommand('SELECT nome FROM produto WHERE idProduto = :id', ['id' => $lista])->queryOne();

                    $mensagem .= " " . $nomeProduto['nome'] . ","; 

                    $produtoSemPreco = true;
                }
            }

            if ($produtoSemPreco) {
                return $this->render('orcamentocomprainsumos', [
                        'model' => $modelOrcamentoCompra,
                        'mensagem' => $mensagem,
                        'output1' => $output1,
                        'output2' => $output2,
                        'output3' => $output3,
                    ]);
            }
            
            //Variavel que irá salvar o valor total da compra de todos os produtos
            $valorTotal = 0;
            
            //laço que pega a coluna que tem o valor de cada produto e adiciona no valor total
            foreach ($resultados as $res) {
                $valororcamento = array_column($res, 'valorCompra');

                $valorFloat = (float)$valororcamento[0];

                $valorTotal += $valorFloat;

            }


            return $this->render('resultadoorcamento', [
                'model' => $modelOrcamentoCompra,
                'valorTotal' => $valorTotal,
                'listaCompleta' => $resultados
            ]);
            
        } else {

            // Caso seja carrregado a view de orçamento sem dados de envio no post o controller
            // redireciona para a view com a lista de insumos
            

            return $this->render('orcamentocomprainsumos', [
                'model' => $modelOrcamentoCompra,
                'output1' => $output1,
                'output2' => $output2,
                'output3' => $output3,
            ]);
        }
    }
}
