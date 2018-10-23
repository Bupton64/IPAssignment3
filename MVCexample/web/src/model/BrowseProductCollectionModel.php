<?php
namespace agilman\a2\model;


/**
 * Class AccountCollectionModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class BrowseProductCollectionModel extends Model
{
    private $productIds;

    private $N;

    /**
     * @return mixed
     */
    public function getN()
    {
        return $this->N;
    }

    public function __construct($tools, $stock)
    {
        parent::__construct();
        if ($stock == 'true') {
            if (!$result = $this->db->query("SELECT * FROM `product` LEFT JOIN `category` 
                                             ON `category`.`id` = `product`.`category`
                                             WHERE `category`.`name` = '$tools' 
                                             AND `product`.`stock_quantity` > 0;")) {
                //add throw
            }
            $this->productIds = array_column($result->fetch_all(), 0);
            $this->N = $result->num_rows;
        } else {
            if (!$result = $this->db->query("SELECT * FROM `product` LEFT JOIN `category` 
                                             ON `category`.`id` = `product`.`category`
                                             WHERE `category`.`name` = '$tools';")) {
                //add throw
            }
            $this->productIds = array_column($result->fetch_all(), 0);
            $this->N = $result->num_rows;
        }
    }

    /**
     * Get account collection
     *
     * @return \Generator|AccountModel[] Accounts
     */
    public function getProducts()
    {
        foreach ($this->productIds as $id) {
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new ProductModel())->load($id);
        }
    }
}
