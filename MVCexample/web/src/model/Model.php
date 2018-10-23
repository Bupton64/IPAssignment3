<?php
namespace agilman\a2\model;

use mysqli;

/**
 * Class Model
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class Model
{
    protected $db;

    // is this the best place for these constants?
    const DB_HOST = 'mysql';
    const DB_USER = 'root';
    const DB_PASS = 'root';
    const DB_NAME = 'a3';

    public function __construct()
    {
        $this->db = new mysqli(
            Model::DB_HOST,
            Model::DB_USER,
            Model::DB_PASS
            //Model::DB_NAME
        );

        if (!$this->db) {
            throw new \Exception($this->db->connect_error, $this->db->connect_errno);
        }

        //----------------------------------------------------------------------------
        // This is to make our life easier
        // Create your database and populate it with sample data
        $this->db->query("CREATE DATABASE IF NOT EXISTS " . Model::DB_NAME . ";");

        if (!$this->db->select_db(Model::DB_NAME)) {
            throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
            error_log("Mysql database not available!", 0);
        }

        $result = $this->db->query("SHOW TABLES LIKE 'account';");

        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE `account` (
                                          `id` int(8) unsigned NOT NULL AUTO_INCREMENT UNIQUE,
                                          `name` varchar(256) DEFAULT NULL,
                                          `username` varchar(256) NOT NULL,
                                          `email` varchar(256) DEFAULT NULL,
                                          `password` varchar (256) NOT NULL,
                                          PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
                error_log("Failed creating table account", 0);
            }

            // Sample accounts
            $password_bob = password_hash("Bobspassword", PASSWORD_BCRYPT);
            $password_mary = password_hash("Maryspassword", PASSWORD_BCRYPT);
            if (!$this->db->query(
                "INSERT INTO `account` VALUES (NULL,'Bob', 'BobTool', 'bob@tools.com', '$password_bob'), 
                                                    (NULL,'Mary', 'MaryTool', 'mary@tools.com', '$password_mary');"
            )) {
                throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
                error_log("Failed creating sample account data!", 0);
            }
        }

        $result = $this->db->query("SHOW TABLES LIKE 'category';");

        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE `category` (
                                          `id` int(8) unsigned NOT NULL AUTO_INCREMENT UNIQUE,
                                          `name` varchar(256) NOT NULL,
                                          PRIMARY KEY (`id`));"
            );

            if (!$result) {
                throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
                error_log("Failed creating table category", 0);
            }

            // Sample products
            if (!$this->db->query(
                "INSERT INTO `category` VALUES (NULL,'Hammers'), 
                                                    (NULL,'Spades'),
                                                    (NULL, 'Paint Brushes'),
                                                    (NULL, 'Power Tools');"
            )) {
                throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
                error_log("Failed creating sample category data!", 0);
            }
        }

        $result = $this->db->query("SHOW TABLES LIKE 'product';");

        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE `product` (
                                          `id` int(8) unsigned NOT NULL AUTO_INCREMENT UNIQUE,
                                          `SKU` varchar(256) NOT NULL UNIQUE,
                                          `name` varchar(256) NOT NULL,
                                          `cost` decimal(16, 2) NOT NULL,
                                          `category` int(8) unsigned NOT NULL,
                                          `stock_quantity` int(8) NOT NULL,
                                          PRIMARY KEY (`id`),
                                          FOREIGN KEY(`category`) REFERENCES `category`(`id`));"
            );

            if (!$result) {
                error_log("Failed creating table product", 0);
                throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
            }

            // Sample products
            if (!$this->db->query(
                "INSERT INTO `product` VALUES (NULL,'HM-04','Claw Hammer', 12.00,1,23), 
                                                    (NULL,'SP-231','Big Spade', 23.00, 2, 11),
                                                    (NULL,'HM-32', 'Mini Hammer', 7.00, 1, 22),
                                                    (NULL,'HM-89Z','Mallet', 35.00, 1, 18),
                                                    (NULL,'PB-58J','Fine Tip Brush',7.50, 3, 76),
                                                    (NULL,'PB-67','Thick Weatherboard Brush', 19.99, 3, 5),
                                                    (NULL,'SP-67','Gravedigging Shovel',31.00,2, 1),
                                                    (NULL,'SP-00','Small Spade',8.20, 2, 23),
                                                    (NULL,'PT-2X','Table Saw', 45.00, 4, 7),
                                                    (NULL,'PT-322','Angle Grinder', 34.50, 4, 11),
                                                    (NULL,'PT-68K','Chainsaw', 27.80, 4, 9),
                                                    (NULL,'PT-Y78','Handheld Drill', 31.20, 4, 2),
                                                    (NULL,'PT-00','Jackhammer', 98.00, 4, 3);"
            )) {
                error_log("Failed creating sample product data!", 0);
                throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
            }
        }

        //----------------------------------------------------------------------------
    }
}
