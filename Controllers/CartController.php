<?php
use Model\Cart;
class CartController {
    static $instance = null;
    public $con = null;
    public function __construct($Adapter){
        $this->con = $Adapter;
    }

    public function getInstance($Adapter){
        if(!self::$instance){
            self::$instance = new CartController($Adapter);
        }
        return self::$instance;   
    }

    public function index(){
        $cart = new \Model\Cart($this->con);
        $result = $cart->read();
        if($result->success == 1){
            http_response_code(200);
            echo json_encode($result);
        }else{
            http_response_code(404);
            echo json_encode($result);
        }
    }

    public function add(){
        $request = $_SERVER["REQUEST_METHOD"];
        if($request == 'POST'){
            $uid = $_SESSION['USER']['u_id'];
            $cart = new \Model\Cart($this->con);
            if(empty($_POST['product'])){
                http_response_code(406);
                echo json_encode(array('message'=>"Invalid data"));
                exit;
            }
            $cart->product = $_POST['product'];
            $result = $cart->create();
            if($result->success == 1){
                http_response_code(201);
                echo json_encode(array('message'=>"product added to cart"));
                exit;
            }else{
                http_response_code(404);
                echo json_encode($result);
                exit;
            }

        }
    }
    
    public function remove(){
        $request = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $array = explode("/", $request);
        $id = $array[3];
        $cart = new \Model\Cart($this->con);
        $cart->id = $id;
        if($requestMethod == "DELETE"){
            $result = $cart->delete();
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