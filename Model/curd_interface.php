<?php 
namespace Model;
interface crud{
    public function read();
    public function create();
    public function update();
    public function delete();
    public function read_one();
}