<?php
use Model\Product;
use PHPUnit\Framework\TestCase;
class IndexControllerTest extends TestCase {
    static $instance = null;
    public $con = null;
    public function __construct($Adapter){
        $this->con = $Adapter;
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