<?php
use Model\Auth;
class AuthController {
    static $instance = null;
    public $con = null;
    public function __construct($Adapter){
        $this->con = $Adapter;
    }

    public function getInstance($Adapter){
        if(!self::$instance){
            self::$instance = new AuthController($Adapter);
        }
        return self::$instance;   
    }
    public function index(){
        $auth = new \Model\Auth($this->con);
        http_response_code(404);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $auth->auth_name     = $_POST['username'];
            $auth->auth_password = $_POST['password'];
            $result = $auth->authenticate();
            if($result['success']){
                http_response_code(200);    
            }else{
                http_response_code(401);
            }
        }else{
            $result['error'] = true;
            $result['message'] = "Invalid Request";
        }
        echo json_encode($result);
        exit();

    }

 
}