<?php

require_once 'constant.php';
require_once 'function.php';
require_once 'Model/Product.php';
require_once 'vendor/autoload.php';
require_once 'Model/Category.php';
require_once 'Model/Auth.php';
require_once 'Model/Cart.php';

$request = $_SERVER['REQUEST_URI'];
$array = explode("/", $request);
$id = intval($array[3]);
$requestedURL =  str_replace(APP_DIR,'',$request);
$requestedMethod = $_SERVER['REQUEST_METHOD']; 
$router = [
    '/' => array('controller'=>'IndexController','action'=>'index'),

    //Create auth route for the user
    '/auth' => ['controller'=>'AuthController','action'=>'index'],
    //product controller routes
    "/product"  => ['controller'=>'ProductController','action'=>'index'], // listing all products
    "/product/add"  => ['controller'=>'ProductController','action'=>'add'],// add new product
    "/product/$id/edit"  => ['controller'=>'ProductController','action'=>'edit'], // update new product
    // if we use GET method then it will return data or if we use DELETE method then product has been deleted from the DB
    "/product/$id"  => ['controller'=>'ProductController','action'=>'get'], // read a single product or delete the product
    //Categories Route;

    "/category"  => [    'controller'=>     'CategoryController','action'=>'index'], // listing all products
    "/category/add"  => ['controller'=>     'CategoryController','action'=>'add'],// add new product
    "/category/$id/edit"  => ['controller'=>'CategoryController','action'=>'edit'], // update new product
    "/category/$id"  => ['controller'=>     'CategoryController','action'=>'get'], // read a single product or delete the product

    //cart Module Routesl
    "/cart"  => [    'controller'=>     'CartController','action'=>'index'], // GET Authenticated user's cart
    "/cart/add"  => ['controller'=>     'CartController','action'=>'add'],// add new product to the cart
    "/cart/$id"  => ['controller'=>     'CartController','action'=>'remove'], // View Delete Product from cart
];

function checkRouting($router, $requestUri){

    if (isset($router[$requestUri])){return true;}
    return false;
}

if (checkRouting($router,$requestedURL)){

    require __DIR__.'/config/Database.php';
    $dbInstance = Database::getInstance();
    $dbAdapter = $dbInstance->getConnection();
    $controller = $router[$requestedURL]['controller'];
    if($controller != 'AuthController' && !isset($_SESSION['API_AUTH'])){
        $getHeader = getallheaders();
        $data = explode(" ",$getHeader['Authorization'])[1];
        $authData = base64_decode($data);
        $auth = new \Model\Auth($dbAdapter);
        $auth->clinet_token = $data;
        $result = $auth->authenticate();
        if($result['success'] != '1'){
            http_response_code(401);
            echo json_encode(array("message"=>"Unauthrized Access"));
            exit();
        }
    }
    $method = $router[$requestedURL]['action'];
    require './Controllers/'.$controller.'.php';
    $object = $controller::getInstance($dbAdapter);
    $methodsOfClass = get_class_methods($object);
    if(in_array($method,$methodsOfClass)){
        $object->$method();
    }else{
        http_response_code(405);
        echo json_encode(['message'=>"Method not allowed"]);
        exit();
    }
 
    exit();
}else{
    http_response_code(404);
    echo json_encode(['message'=>"Page not found"]);
}