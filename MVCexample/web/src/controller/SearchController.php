<?php
namespace agilman\a2\controller;
session_start();
use agilman\a2\view\View;
use agilman\a2\model\ProductCollectionModel;
/**
 * Class HomeController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class SearchController extends Controller
{
    /**
     * Link to Welcome
     */
    public function liveSearchAction()
    {
        $q=$_GET["q"];
        if (strlen($q)>0) {
            $livesearch = new SearchProductCollectionModel($q);
            $products = $livesearch->getProducts();
            if($livesearch->getN() == 0){
                echo "No matches found";
            } else {
                $result = $this->format($products);
                echo $result;
            }
        }else{
            echo "";
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
