<?php
namespace Model;

use Exception;
use Model\Product;
class Cart{

    static $instance = null;
    public $con = null;
    private $table = "shopping_cart";
    
    public $product;

    public $id;
    public $uid;
    public $price;
    public $discount;
    public $tax;
    public $created;
    public $modified;

    public function __construct($Adapter){
        $this->con = $Adapter;
    }


    public function read(){
        $query = "SELECT * FROM ".$this->table." WHERE cart_user_id = :uid";
        $stmt  = $this->con->prepare($query);
        $stmt->bindParam('uid',$_SESSION['USER']['u_id']);
        $result = $stmt->execute();
        if($result == 1){
            $cart = $stmt->fetchAll();
            if(empty($cart)){
                return (object)array("success"=>true,"message"=>"Nothing available in cart");
            }
            /* Product calculation part */
            /* @var TotalCartValue */
            /* @var TotalCartDiscount */
            /* @var TotalCartTax */
            $TotalTax = 0;
            $TotalDiscount = 0;
            $TotalCartValue = 0;
            foreach($cart as $cart_key => $cart_value){
                $product = new \Model\Product($this->con);
                $product->id  = $cart_value['cart_product_id'];
                $product_data = $product->read_one();
                $discount = calculate_discount($cart_value['cart_product_price'],$cart_value['cart_product_discount']);
                $tax = calculate_tax($cart_value['cart_product_price'],$cart_value['cart_product_tax']);
                $Product_CartAmount =  $cart_value['cart_product_price'] - $discount + $tax;
                $TotalCartValue += bcdiv($Product_CartAmount,1,2);
                $TotalTax += $tax; 
                $TotalDiscount += $discount; 
                $CartData['product_name'] = $product_data->data->name;
                $CartData['product_description'] = $product_data->data->name;
                $CartData['product_category'] = $product_data->data->category;
                $CartData['product_actual_price'] = $cart_value['cart_product_price'];
                $CartData['product_amount'] = $Product_CartAmount;
                $CartData['product_tax'] = $tax;
                $CartData['product_discount'] = $discount;
                $OverallCart[] = $CartData;
            }
            $OverallCart['cartTotalAmount'] = $TotalCartValue;
            $OverallCart['cartTotalTax'] = $TotalTax;
            $OverallCart['cartTotalDiscount'] = $discount;
            return (object)array("success"=>true,"data"=>$OverallCart);
        }else{
            return (object)array("error"=>true,"message"=>"Something went wrong");
        }
    }

    public function create(){
        $product = new  \Model\Product($this->con);
        $product->id = $this->product;
        $data = $product->read_one();
        if($data->success == '1'){
            $query = "INSERT INTO ".$this->table." SET cart_user_id = :cuid,cart_product_id = :cpid,cart_product_price = :cprice,cart_product_discount = :cdiscount,cart_product_tax = :ctax,cart_created = :ccreated,cart_modfied = :cmodified";
            $stmt = $this->con->prepare($query);
            $stmt->bindParam(':cuid'     ,$_SESSION['USER']['u_id']);
            $stmt->bindParam(':cpid'     ,$data->data->id);
            $stmt->bindParam(':cprice'   ,$data->data->price);
            $stmt->bindParam(':cdiscount',$data->data->discount);
            $stmt->bindParam(':ctax'     ,$data->data->tax);
            $stmt->bindParam(':ccreated' ,date('Y-m-d H:i:s'));
            $stmt->bindParam(':cmodified',date('Y-m-d H:i:s'));
            $result = $stmt->execute();
            if($result == 1){
                return (object)array("success"=>true,"message"=>"Product added to cart");
            }else{
                return (object)array("error"=>true,"message"=>"Something went wrong");
            }
        }else{
            return (object)array("error"=>true,"message"=>"Prodcut not found ");
        }
    }


    public function delete(){
        $query = "DELETE FROM ".$this->table." WHERE cart_id = :pid";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':pid',$this->id);
        $result = $stmt->execute(); 
        if($result == '1'){
            return (object)array('success'=>true,'message'=>"Product removed from cart");
        }
        return (object)array('error'=>true,'message'=>"Something went wrong");
    }


}