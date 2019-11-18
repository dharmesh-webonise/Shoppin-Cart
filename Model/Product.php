<?php
namespace Model;
include_once 'curd_interface.php';
class Product implements crud{

    private $con;
    private $table = 'products';

    public $id;
    public $name;
    public $description;
    public $created;
    public $category;
    public $category_id;
    public $price;
    public $discount;
    public $tax;
    public $modified;
    public $dataArray;

    public function __construct($Adapter){
        $this->con = $Adapter;
    }

    public function read(){
        $query = "SELECT * FROM ".$this->table." LEFT JOIN categories ON c_id = p_category WHERE 1";
        $stmt = $this->con->prepare($query);
        $result = $stmt->execute();
        $data = $stmt->fetchAll();
        if(empty($data)){
            return array("error"=>true,'message'=>"No data found");
        }
        $data_array = array();
        foreach ($data as $key => $value) {
            $data_array['id'] = $value['p_id'];
            $data_array['name'] = $value['p_name'];
            $data_array['description'] = $value['p_description'];
            $data_array['created'] = $value['p_created'];
            $data_array['price'] = $value['p_price'];
            $data_array['category'] = $value['c_name'];
            $data_array['category_id'] = $value['c_id'];
            $this->dataArray[] = $data_array;  
        }
        return array("success"=>true,'data'=>$this->dataArray);
    }

    public function read_one(){
        $query = "SELECT * FROM ".$this->table."  LEFT JOIN categories ON c_id = p_category  WHERE  p_id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':id',$this->id);
        $result = $stmt->execute();
        $data = $stmt->fetch();
        if(empty($data)){
            return (object)array("error"=>true,'message'=>"No data found");
        }else{
            extract($data);
            $this->id = $p_id;
            $this->name = $p_name;
            $this->description = $p_description;
            $this->price = $p_price;
            $this->category = $c_name;
            $this->category_id = $c_id;
            $this->discount = $p_discount;
            $this->tax = $c_tax;
            return (object)array("success"=>true,'data'=>$this);
        }
    }

    public function create(){
        $query = "INSERT INTO ".$this->table." SET p_name = :pname,p_description=:pdesc,p_price=:pprice,p_discount = :pdiscount,p_category = :pcat,p_created = :pcreated,p_modified= :pcreated";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':pname',$this->name);
        $stmt->bindParam(':pdesc',$this->description);
        $stmt->bindParam(':pdiscount',$this->discount);
        $stmt->bindParam(':pprice',$this->price);
        $stmt->bindParam(':pcat',$this->category);
        $stmt->bindParam(':pcreated',date('Y-m-d H:i:s'));
        $stmt->bindParam(':pmodified',date('Y-m-d H:i:s'));
        $result = $stmt->execute(); 
        if($result == '1'){
            return (object)array('success'=>true,'message'=>"Product Created");
        }
        return (object)array('error'=>true,'message'=>"Something went wrong");
    }

    public function update(){
        $query = "UPDATE  ".$this->table." SET p_name = :pname,p_description=:pdesc,p_price=:pprice,p_discount = :pdiscount,p_category = :pcat,p_modified= :pcreated WHERE p_id = :pid";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':pname',$this->name);
        $stmt->bindParam(':pdesc',$this->description);
        $stmt->bindParam(':pprice',$this->price);
        $stmt->bindParam(':pdiscount',$this->discount);
        $stmt->bindParam(':pcat',$this->category);
        $stmt->bindParam(':pcreated',$this->created);
        $stmt->bindParam(':pid',$this->id);
        $result = $stmt->execute(); 
        if($result == '1'){
            return (object)array('success'=>true,'message'=>"Product Updated");
        }
        return (object)array('error'=>true,'message'=>"Something went wrong");
    }

    public function delete(){
        $query = "DELETE FROM ".$this->table." WHERE p_id = :pid";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':pid',$this->id);
        $result = $stmt->execute(); 
        if($result == '1'){
            return (object)array('success'=>true,'message'=>"Product Deleted");
        }
        return (object)array('error'=>true,'message'=>"Something went wrong");
    }

}