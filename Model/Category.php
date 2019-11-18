<?php
namespace Model;
include_once 'curd_interface.php';
class Category implements crud{

    private $con;
    private $table = 'categories';

    public $id;
    public $name;
    public $description;
    public $tax;
    public $modified;
    public $created;

    public function __construct($Adapter){
        $this->con = $Adapter;
    }

    public function read(){
        $query = "SELECT * FROM ".$this->table." WHERE 1";
        $stmt = $this->con->prepare($query);
        $result = $stmt->execute();
        $data = $stmt->fetchAll();
        if(empty($data)){
            return array("error"=>true,'message'=>"No data found");
        }
        $data_array = array();
        foreach ($data as $key => $value) {
            $data_array['id'] = $value['c_id'];
            $data_array['name'] = $value['c_name'];
            $data_array['description'] = $value['c_description'];
            $data_array['created'] = $value['c_created'];
            $data_array['tax'] = $value['c_tax'];
            $dataArray[] = $data_array;
        }
        return array("success"=>true,'data'=>$dataArray);
    }

    public function read_one(){
        $query = "SELECT * FROM ".$this->table."  WHERE  c_id  = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':id',$this->id);
        $result = $stmt->execute();
        $data = $stmt->fetch();
        if(empty($data)){
            return (object)array("error"=>true,'message'=>"No data found");
        }else{
            extract($data);
            $this->id = $c_id;
            $this->name = $c_name;
            $this->description = $c_description;
            $this->tax = $c_tax;
            return (object)array("success"=>true,'data'=>$this);
        }
    }

    public function create(){
        $query = "INSERT INTO ".$this->table." SET c_name = :cname,c_description =:cdesc,c_tax=:ctax,c_created = :ccreated,c_modified= :ccreated";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':cname',$this->name);
        $stmt->bindParam(':cdesc',$this->description);
        $stmt->bindParam(':ctax',$this->tax);
        $stmt->bindParam(':ccreated',date('Y-m-d H:i:s'));
        $stmt->bindParam(':ccreated',date('Y-m-d H:i:s'));
        $result = $stmt->execute();
        if($result == '1'){
            return (object)array('success'=>true,'message'=>"Category Created");
        }
        return (object)array('error'=>true,'message'=>"Something went wrong");
    }

    public function update(){
        $query = "UPDATE  ".$this->table." SET c_name = :cname,c_description =:cdesc,c_tax=:ctax,c_modified= :ccreated WHERE c_id = :cid";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':cname',$this->name);
        $stmt->bindParam(':cdesc',$this->description);
        $stmt->bindParam(':ctax',$this->tax);
        $stmt->bindParam(':ccreated',date('Y-m-d H:i:s'));
        $stmt->bindParam(':cid',$this->id);
        $result = $stmt->execute();
        if($result == '1'){
            return (object)array('success'=>true,'message'=>"Category Updated");
        }
        return (object)array('error'=>true,'message'=>"Something went wrong");
    }

    public function delete(){
        $query = "DELETE FROM ".$this->table." WHERE c_id = :cid";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':cid',$this->id);
        $result = $stmt->execute();
        if($result == '1'){
            return (object)array('success'=>true,'message'=>"Category Deleted");
        }
        return (object)array('error'=>true,'message'=>"Something went wrong");
    }

}