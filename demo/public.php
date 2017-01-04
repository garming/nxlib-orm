<?php
include dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."vendor/autoload.php";
function console($data){
    print_r($data);
    echo "\r\n";
}
function vd($data){
    var_dump($data);
    echo "\r\n";
}