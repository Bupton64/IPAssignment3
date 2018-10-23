<?php
namespace agilman\a2\controller;
session_start();
use agilman\a2\view\View;
use agilman\a2\model\ProductCollectionModel;
/**
 * Class BrowseController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class BrowseController extends Controller
{
    public function displayBrowse(){
        // Need to build a list of products to display via queries.
        $stock = $_GET['stock'];
        $hammers = $_GET['hammer'];
        $powerT = $_GET['powerT'];
        $paintB = $_GET['paintB'];
        $spades = $_GET['spades'];

    }

    public function collectToolType($tool){
        if($hammers){
            error_log("Trying to collect hammers");
            if($stock){

            } else{

            }
        }
    }

    public function format($products){
        $response = "<table><tr><th>SKU</th><th>Name</th><th>Cost</th><th>Category</th><th>Quantity</th></tr>";
        foreach ($products as $product){
            $response = $response."<tr><td>".$product->getSku()."</td><td>".$product->getName()."</td><td>".$product->getCost()."</td><td>".$product->getCategory()."</td><td>".$product->getQuantity()."</td></tr>";
        }
        $response = $response.'</table>';
        return $response;
    }
}
