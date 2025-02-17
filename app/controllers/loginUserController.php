<?php
header('Content-Type: application/json');
// header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PATCH, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit;
}


require('../../config/connection.php');
require('../models/User.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $User = new User($conn);
    $User->login($data['email'], $data['password']);

}


?>