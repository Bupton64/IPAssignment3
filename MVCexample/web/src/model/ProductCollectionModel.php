<?php
namespace agilman\a2\model;

/**
 * Class AccountCollectionModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class ProductCollectionModel extends Model
{
    private $productIds;

    private $N;

    public function __construct($q)
    {
        parent::__construct();



        if(!$result = $this->db->query("SELECT * FROM `product` WHERE `name` LIKE '%{$q}%';")){
            //add throw
        }
        error_log("hint num rows is ".$result->num_rows);


        $this->productIds = array_column($result->fetch_all(), 0);
        $this->N = $result->num_rows;
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