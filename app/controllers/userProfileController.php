<?php
session_start();
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

$User = new User($conn);

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $User->getUser($_GET['user_id']);

}else if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user_id = intval($_SESSION['user_id']);
    
    if(!isset($_POST['user_name'])){
        $username = null;
    }else{
        $username = $_POST['user_name'];
    };
    if(!isset($_POST['bio'])){
        $bio = null;
    }
    else{
        $bio = $_POST['bio'];
    };
    if(!isset($_FILES['image'])){
        $image = null;
    }else{
        $image = $_FILES['image'];
    };
    

    $User->editUser($user_id, $username, $bio, $image);

}


?>