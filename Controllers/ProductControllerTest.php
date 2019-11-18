<?php
require 'ProductController.php';
require __DIR__.'/../config/Database.php';

use config\Database;
use PHPUnit\Framework\TestCase;
class ProductControllerTest extends TestCase {
    private $con;



    public function testGet(){
        
        $this->assertEquals(200,200);
    }
}