<?php 
session_start();
require("../../config/connection.php");
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include("../models/User.php");

$User = new User($conn);

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(!isset($_GET['page'])){

        $User->getAllUsers(null);

    }else{

        $User->getAllUsers($_GET['page']);

    }

}else if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(!isset($_FILES['avatar']['name']) || empty($_FILES['avatar']['name'])){

        $file = null;
    }else {
        
        $file = $_FILES['avatar'];

    }

    $User->updateUser($_POST['user-id'], $file, $_POST["user-name"], $_POST["email"], $_POST["role"], $_POST["bio"]);

}else if($_SERVER['REQUEST_METHOD'] == "PATCH"){

    $data = file_get_contents("php://input");
    $user = json_decode($data, TRUE);

    $user_id = intval($user['userId']);
    $User->deleteUser($user_id);

}
?>