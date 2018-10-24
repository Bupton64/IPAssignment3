<?php
namespace agilman\a2\model;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class ProductModel
 *
 * Contains data and behaviour for any products in the syste,.
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class ProductModel extends Model
{

    /**
     * @var $id, the unique id of the product
     */
    private $id;
    /**
     * @var $sku, the stock keeping unit of the product
     */
    private $sku;
    /**
     * @var $name, the name of the product
     */
    private $name;
    /**
     * @var $cost, the price of the product
     */
    private $cost;
    /**
     * @var $category, what category the product fits into
     */
    private $category;
    /**
     * @var $quantity, how many of the product is in stock.
     */
    private $quantity;

    /**
     * @return mixed the unique id of the product
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id, the id to set to.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed, the stock keeping unit of the product
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku , the new SKU for the product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed, the name of the product
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name, the new name to set the product to
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed, the price of the product
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost, the price to set the product to
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed, what category the product fits into
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category, the new category of the product
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed, how many of the product is in stock.
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity, the new quantity of the stock.
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Loads product information from the database
     *
     * @param int $id Product ID, the id of the product to load from the database
     *
     * @return $this ProductModel, the modified object.
     *
     * @throws \mysqli_sql_exception, if the SQL query fails
     */
    public function load($id)
    {
        if (!$result = $this->db->query("SELECT * FROM `product` WHERE `id` = $id;")) {
            throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
        }
        $result = $result->fetch_assoc();
        $this->name = $result['name'];
        $this->sku = $result['SKU'];
        $this->cost = $result['cost'];
        $this->quantity = $result['stock_quantity'];
        $category_id = $result['category'];
        if (!$result = $this->db->query("SELECT `name` FROM `category` WHERE `id` = $category_id;")) {
            throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
        }
        $result = $result->fetch_assoc();
        $this->category = $result['name'];
        ;
        $this->id = $id;
        return $this;
    }
}
