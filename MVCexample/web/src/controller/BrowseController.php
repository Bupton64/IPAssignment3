<?php
namespace agilman\a2\controller;
session_start();
use agilman\a2\view\View;
use agilman\a2\model\BrowseProductCollectionModel;
/**
 * Class BrowseController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class BrowseController extends Controller
{
    private $response = "";

    public function browseAction(){
        // Need to build a list of products to display via queries.
        $stock = $_GET['stock'];
        $hammers = $_GET['hammer'];
        $powerT = $_GET['powerT'];
        $paintB = $_GET['paintB'];
        $spades = $_GET['spades'];
        if($hammers == 'true' || $powerT == 'true' || $paintB == 'true' || $spades == 'true'){ // ensure at least one product is being searched for
            $this->response = $this->response."<table><tr><th>SKU</th><th>Name</th><th>Cost</th><th>Category</th><th>Quantity</th></tr>";
            if($hammers == 'true'){
                $this->response = $this->response.$this->collectToolType($stock, "Hammers");
            }
            if($powerT == 'true'){
                $this->response = $this->response.$this->collectToolType($stock, "Power tools");
            }
            if($paintB == 'true'){
                $this->response = $this->response.$this->collectToolType($stock, "Paint Brushes");
            }
            if($spades == 'true'){
                $this->response = $this->response.$this->collectToolType($stock, "spades");
            }
            $this->response = $this->response."</table>";
        } else {
            $this->response = "No selection criteria.";
        }
        echo $this->response;
    }

    //NOTE Collection is a debug line
    public function collectToolType($stock, $tool){
        error_log("Trying to collect...".$tool);
        if($stock){
            $tools = new BrowseProductCollectionModel($tool, $stock);
        } else{
            $tools = new BrowseProductCollectionModel($tool, $stock);
        }
        $category = $tools->getProducts();
        $result = $this->format($category);
        return $result;
    }

    public function format($products){
        $r = "";
        foreach ($products as $product){
            $r = $r."<tr><td>".$product->getSku()."</td><td>".$product->getName()."</td><td>".$product->getCost()."</td><td>".$product->getCategory()."</td><td>".$product->getQuantity()."</td></tr>";
        }
        return $r;
    }
}
