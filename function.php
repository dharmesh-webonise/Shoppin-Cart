<?php 
function prd($val){
    echo "<pre>";
    print_r($val);
    echo "</pre>";
    exit();
}
function pr($val){
    echo "<pre>";
    print_r($val);
    echo "</pre>";
}


function calculate_discount($price,$discount){
    $var = $price * $discount;
    $var = $var/100;
    return bcdiv($var,1,2);
}
function calculate_tax($price,$tax){
    $var = $price * $tax;
    $var = $var/100;
    return bcdiv($var,1,2);
}
