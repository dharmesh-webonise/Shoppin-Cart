<?php
namespace Model;
class Auth{
    static $instance = null;
    public $con = null;
    private $table = 'users';
    public $auth_name;
    public $auth_password;
    public $clinet_token;

    public function __construct($Adapter){
        $this->con = $Adapter;
    }

    public function authenticate(){
        $getToken = explode(':',base64_decode($this->clinet_token));
        $this->auth_name = $getToken[0];
        $this->auth_password = $getToken[1];
        $query = "SELECT * FROM ".$this->table." where username = :uname AND password = :upassword";
        $stmt  = $this->con->prepare($query);
        $stmt->bindParam(':uname',$this->auth_name);
        $stmt->bindParam(':upassword',$this->auth_password);
        $result = $stmt->execute();
        if($result == '1'){
            $data = $stmt->fetch();
            
            if(!empty($data)){
                $_SESSION['USER'] = $data;
                return array('success'=>true,'message'=>'User Authenticated successfully');
            }else{
                return array('error'=>true,'message'=>'Authentication Failed');
            }
        }else{
            return array('error'=>true,'message'=>'Authentication Failed');
        }
    }

    public function validateToken(){
        $query = "SELECT * FROM ".$this->table." where client_token = :c_token";
        $stmt  = $this->con->prepare($query);
        $stmt->bindParam(':c_token',$this->clinet_token);
        $result = $stmt->execute();
        if($result == '1'){
            return array('success'=>true,'message'=>'Token Validated');
        }else{
            return array('error'=>true,'message'=>'Invalid Token');
        }
    }


    public function getClientToken(){
        return $this->clinet_token;
    }

}