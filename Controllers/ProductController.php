<?php
use Model\Product;
class ProductController {
    static $instance = null;
    public $con = null;
    public function __construct($Adapter){
        $this->con = $Adapter;
    }

    public function getInstance($Adapter){
        if(!self::$instance){
            self::$instance = new ProductController($Adapter);
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

    public function add(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(empty($_POST)){
                http_response_code(406);
                echo json_encode(array('message'=>"Invalid data"));
                exit;
            }

            if(empty($_POST['name']) && empty($_POST['description']) && empty($_POST['price']) && empty($_POST['category'])){
                http_response_code(406);
                echo json_encode(array('message'=>"Invalid data"));
                exit;
            }

            if(!is_numeric($_POST['price'])){
                http_response_code(406);
                echo json_encode(array('message'=>"Price should be in integer or decimal"));
                exit;
            }

            if(!is_numeric($_POST['category'])){
                http_response_code(406);
                echo json_encode(array('message'=>"Invalid Category"));
                exit;
            }
            
            $product = new \Model\Product($this->con);
            $product->name = strip_tags($_POST['name']);
            $product->description = strip_tags($_POST['description']);
            $product->price = strip_tags($_POST['price']);
            $product->category = strip_tags($_POST['category']);
            $product->name = strip_tags($_POST['name']);
            $product->name = strip_tags($_POST['name']);
            $result = $product->create();
            if($result->success == '1'){
                http_response_code(201);
            }else{
                http_response_code(406);
            }
            echo json_encode($result);
            exit;
        }else{
            http_response_code(400);
            echo json_encode(array('message'=>"Invalid Request"));
        }
    }

    public function edit(){
        $request = $_SERVER['REQUEST_URI'];
        $array = explode("/", $request);
        $id = $array[3];
        $header = getallheaders();
        if($_SERVER['REQUEST_METHOD'] == 'PATCH' || $_SERVER['REQUEST_METHOD'] == 'POST'){
            if(empty($_REQUEST)){
                $files = file_get_contents('php://input');
                parse_str($files,$data);
            }else{
                $data = $_REQUEST;
            }
        }else{
            http_response_code(400);
            echo json_encode(array('message'=>"Invalid Request"));
            exit;
        }

        $product = new \Model\Product($this->con);
        $product->id = $id;
        $isExist = $product->read_one();

        if($isExist->error == '1'){
            http_response_code(406);
            echo json_encode(array('message'=>"Invalid data"));
            exit;
        }

        
        if(empty($data)){
            http_response_code(406);
            echo json_encode(array('message'=>"Invalid data"));
            exit;
        }
        
        if(empty($data['name']) && empty($data['description']) && empty($data['price']) && empty($data['discount']) && empty($data['category'])){
            http_response_code(406);
            echo json_encode(array('message'=>"Invalid data"));
            exit;
        }


        if(!is_numeric($data['price'])){
            http_response_code(406);
            echo json_encode(array('message'=>"Price should be in integer or decimal"));
            exit;
        }

        if(!is_numeric($data['discount'])){
            http_response_code(406);
            echo json_encode(array('message'=>"Price should be in integer or decimal"));
            exit;
        }

        if(!is_numeric($data['category'])){
            http_response_code(406);
            echo json_encode(array('message'=>"Invalid Category"));
            exit;
        }
            
        $product->name = strip_tags($data['name']);
        $product->description = strip_tags($data['description']);
        $product->price = strip_tags($data['price']);
        $product->category = strip_tags($data['category']);
        $product->name = strip_tags($data['name']);
        $product->discount = strip_tags($data['discount']);
        $result = $product->update();
        if($result->success == '1'){
            http_response_code(200);
        }else{
            http_response_code(406);
        }
        echo json_encode($result);
        exit;
    }
    
    public function get(){
        $request = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $array = explode("/", $request);
        $id = $array[3];
        $product = new \Model\Product($this->con);
        $product->id = $id;
        if($requestMethod == "DELETE"){
            $result = $product->delete();
        }else{
            $result = $product->read_one();
        }
        echo json_encode($result);
        http_response_code(404);
        if($result['success']){
            http_response_code(200);
        }
        echo json_encode($result);
        exit();
    }
    
}