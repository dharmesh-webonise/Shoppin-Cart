<?php
class Database{
    static $instance = null;
    private $connection = null;

    // private $host           = DB_HOST;
    // private $user           = DB_USER;
    // private $db_name        = DB_NAME;
    // private $db_password    = DB_PASSWORD;

    private $host           = 'localhost';
    private $user           = 'root';
    private $db_name        = 'shoping_cart_api';
    private $db_password    = 'Test@123';

    public function __construct(){
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->user,$this->db_password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    public function getInstance(){
        if(!self::$instance){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->connection; 
    }

}