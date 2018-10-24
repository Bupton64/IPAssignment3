<?php
namespace agilman\a2\controller;
session_start();
use agilman\a2\view\View;
use agilman\a2\model\SearchProductCollectionModel;
/**
 * Class SearchController
 *
 * Controller to manage the applications search functionality.
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class SearchController extends Controller
{
    /**
     * Processes the user search query and generates an appropriate response
     */
    public function liveSearchAction()
    {
        $q=$_GET["q"];
        if (strlen($q)>0) {
            try {
                $livesearch = new SearchProductCollectionModel($q);
                $products = $livesearch->getProducts();
            } catch (\Exception $e){
                $this->redirect('error');
            }
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

    /***
     * @param $products SearchProductCollectionModel, a list of products to be processed
     * @return string $response, the HTML formatted table to be sent back to the client.
     */
    public function format($products){
        $response = "<table><tr><th>SKU</th><th>Name</th><th>Cost</th><th>Category</th><th>Quantity</th></tr>";
        foreach ($products as $product){
            $response = $response."<tr><td>".$product->getSku()."</td><td>".$product->getName()."</td><td>".$product->getCost()."</td><td>".$product->getCategory()."</td><td>".$product->getQuantity()."</td></tr>";
        }
        $response = $response.'</table>';
        return $response;
    }
}
