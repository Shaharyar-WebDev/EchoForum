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
require('../models/Thread.php');

$Thread = new Thread($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(!isset($_SESSION['user_id'])){

        $response['status'] = 'error';
        $response['msg'] = 'you need to log in to add Threads!';
        echo json_encode($response);

        exit;

    }
    // if(!isset($_POST['type'] || $_POST['type'] !== 'view'){

    //          $Thread->viewThread($data['user_ip'], $data['thread_id']);

    //         exit;

    // }else{}

    if (empty($_FILES['image']['name'])) {

        $_FILES['image'] = null;

       
        $Thread->addThread($_SESSION['user_id'], $_POST['category'], $_POST['thread-title'], $_POST['content'], $_FILES['image']);
    } else {


        $Thread->addThread($_SESSION['user_id'], $_POST['category'], $_POST['thread-title'], $_POST['content'], $_FILES['image']);
    }
}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){

    

        if(isset($_GET['thread_id'])){
           
            $thread_id = intval($_GET['thread_id']);

            $Thread->getThread($thread_id, null, null, null);

        } else if (isset($_GET['search'])){

            $Thread->getThread(null, null, true, $_GET['search']);

        } else if(isset($_GET['category_id'])){
           
            $category_id = intval($_GET['category_id']);

            $Thread->getThread(null,$category_id, null, null);

        }else{
        
            $Thread->getThread(null, null, true, null);
        
        }
} else if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {

    $data = json_decode(file_get_contents("php://input"), TRUE);

    if ($data['action'] == 1) {

        if (!isset($_SESSION['user_id'])) {

            $response['status'] = 'info';
            $response['msg'] = 'you need to log in to like Threads!';
            echo json_encode($response);
        } else {

            $Thread->likeThread($_SESSION['user_id'], $data['thread_id']);

            exit;
        }
    } else {

        // $response['status'] = 'success';
        // $response['msg'] = "ip is " . $data['user_ip'];
        // $response['action'] = $data['action'];
        // echo json_encode($response);
        if(!isset($data['user_ip'])){

            return false;
        }else{

            $Thread->viewThread($data['user_ip'], $data['thread_id']);

            exit;

        }

    }
}
?>