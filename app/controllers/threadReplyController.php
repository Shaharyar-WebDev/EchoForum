<?php
session_start();
header('Content-Type: application/json');
// header("Acces-Control-Allow-Origin: *");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PATCH, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit;
}


require("../../config/connection.php");
require("../models/Reply.php");

$ThreadReply = new ThreadReply($conn);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // echo var_dump($_POST);

    
    if(!isset($_SESSION['user_id'])){

        $response['msg'] = "You Need to login to reply Threads!!";
        $response['status'] = "warning";

        echo json_encode($response);
        return false;

    }else{

    $ThreadReply->addReply($_SESSION['user_id'], $_POST['thread_id'], $_POST['reply'] );

    }

}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(!isset($_GET['thread_id'])){

        $response['msg'] = "ERROR! Thread ID MISSING";
        $response['status'] = "error";

        echo json_encode($response);
        return false;

    }else{

        if(!isset($_GET['sort']) || $_GET['sort'] == 'false'){

            
        $ThreadReply->getReply($_GET['thread_id'], null);
        exit;

        }else{

        $ThreadReply->getReply($_GET['thread_id'], $_GET['sort']);
        exit;

        }

    }


}else if($_SERVER['REQUEST_METHOD'] == 'PATCH'){

    if(!isset($_SESSION['user_id'])){

        $response['msg'] = "You Need To Login To Like Replies";
        $response['status'] = "info";
    
        echo json_encode($response);
    
    }else{

        $data = json_decode(file_get_contents("php://input"), TRUE);

        $ThreadReply->likeReply($_SESSION['user_id'], $data['reply_id']);

    }

}

?>