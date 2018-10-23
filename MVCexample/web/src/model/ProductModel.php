<?php
namespace agilman\a2\model;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class AccountModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class ProductModel extends Model
{

    private $id;
    private $sku;
    private $name;
    private $cost;
    private $category;
    private $quantity;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }



    /**
     * Loads account information from the database
     *
     * @param int $id Account ID
     *
     * @return $this AccountModel
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
        if(!$result = $this->db->query("SELECT `name` FROM `category` WHERE `id` = $category_id;")){
            throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
        }
        $result = $result->fetch_assoc();
        $this->category = $result['name'];;
        $this->id = $id;
        return $this;
    }







}
