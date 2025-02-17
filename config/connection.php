<?php

$host_name = 'sql113.infinityfree.com';
$user_name = 'if0_38308354';
$password = 'QtttTgBUlHH5S';
$database = 'if0_38308354_echoforum';

try{

    $conn = new mysqli($host_name, $user_name, $password, $database);


}catch(Exception $error){

    throw new Exception('Connection Failed', $error->getMessage());
};


?>