<?php 
namespace app\models;

use Yii;
use app\models\Produto;

class ProdutoVenda extends Produto{
   
    private $insumos = array();
    
    public function getInsumos(){
     return $this->insumos;
 }
 
 
 public function addInsumo($insumo){
     if (isset($insumo)) {
     array_push($this->insumos, $insumo);

     }
     return $this->insumos;
 }
 
 public function removeInsumo($insumo){
     if (isset($insumo)) {
         $key = array_search($insumo, $this->insumos);
    unset($this->insumos[$key]);

     }
     return $idsproduto_insumos;
 }

}


?>