<?php
use Model\Product;
class IndexController {
    static $instance = null;
    public $con = null;
    public function __construct($Adapter){
        $this->con = $Adapter;
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function getInstance($Adapter){
        if(!self::$instance){
            self::$instance = new IndexController($Adapter);
        }
        return self::$instance;   
    }
    public function index(){
        $product = new \Model\Product($this->con);
        $result = $product->read();
        http_response_code(404);
        if($result['success']){
            http_response_code(200);
        }
        echo json_encode($result);
        exit();
    }

    public function checkpost(){
        // prd($this->checkRequest());
        // prd($_SERVER);
    }

}