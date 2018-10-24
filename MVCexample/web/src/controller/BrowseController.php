<?php
namespace agilman\a2\controller;
session_start();
use agilman\a2\view\View;
use agilman\a2\model\BrowseProductCollectionModel;
/**
 * Class BrowseController
 *
 * Controller to manage the applications browse functionality.
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class BrowseController extends Controller
{
    /***
     * @var string The result to be returned from each browse query.
     */
    private $response = "";

    /***
     * Generates a response for a browse query based on a list of selection
     * Flags available to the user.
     */
    public function browseAction()
    {
        $stock = $_GET['stock'];
        $hammers = $_GET['hammer'];
        $powerT = $_GET['powerT'];
        $paintB = $_GET['paintB'];
        $spades = $_GET['spades'];
        if ($hammers == 'true' || $powerT == 'true' || $paintB == 'true' || $spades == 'true') { // ensure at least one product is being searched for
            $this->response = $this->response . "<table><tr><th>SKU</th><th>Name</th><th>Cost</th><th>Category</th><th>Quantity</th></tr>";
            if ($hammers == 'true') {
                $this->response = $this->response . $this->collectToolType($stock, "Hammers");
            }
            if ($powerT == 'true') {
                $this->response = $this->response . $this->collectToolType($stock, "Power tools");
            }
            if ($paintB == 'true') {
                $this->response = $this->response . $this->collectToolType($stock, "Paint Brushes");
            }
            if ($spades == 'true') {
                $this->response = $this->response . $this->collectToolType($stock, "spades");
            }
            $this->response = $this->response . "</table>";
        } else {
            $this->response = "No selection criteria.";
        }
        echo $this->response;
    }

    /**
     * Gathers a category of tools and formats them for output.
     *
     * @param $stock Bool, Determines whether the user has selected to restrict the query to in stock products only.
     * @param $tool string, The category of tools to be collected and processed
     * @return string $result, The HTML formatted string to be collated as part of a table response.
     */
    public function collectToolType($stock, $tool)
    {
        try {
            $tools = new BrowseProductCollectionModel($tool, $stock);
            $category = $tools->getProducts();
        } catch (\Exception $e) {
            $this->redirect('error');
        }
        $result = $this->format($category);
        return $result;
    }

    /**
     * Formats a list of products for output.
     *
     * @param $products BrowseProductCollectionModel, A list of products to be processed
     * @return string $r, the list of products in an HTML formatted string.
     */
    public function format($products)
    {
        $r = "";
        foreach ($products as $product) {
            $r = $r . "<tr><td>" . $product->getSku() . "</td><td>" . $product->getName() . "</td><td>" . $product->getCost() . "</td><td>" . $product->getCategory() . "</td><td>" . $product->getQuantity() . "</td></tr>";
        }
        return $r;
    }
}
