<?php
session_start();
require('../config/connection.php');
// echo $_SESSION['user_name'];
if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {

    $allowed_pages = ["home", "addThread", "profile", "thread", "404", "403", "admin"];
} else {

    $allowed_pages = ["home", "addThread", "profile", "thread", "404", "403"];
}
if (isset($_GET['logout']) && $_GET['logout'] == true) {

    session_unset();
    session_destroy();
    header("location: .?page=home");
    exit;
}

if (isset($_GET['page'])) {

    if (in_array($_GET['page'], $allowed_pages)) {

        $page = $_GET['page'];
    } else {

        header("location: .?page=404");

        exit;
    }
} else {

    header("location: .?page=home");

    exit;
}

if($_GET['page'] == 'thread'){
if(!isset($_GET['thread_id']) || empty($_GET['thread_id']) || !intval($_GET['thread_id'])){

    
    header("location: .?page=home");

    exit;

}
}

if($_GET['page'] == 'profile'){

    if(!isset($_GET['user']) || empty($_GET['user']) || !intval($_GET['user'])){

        if(isset($_SESSION['user_id'])){

            header("location: .?page=profile&user=$_SESSION[user_id]");    
    
        }

    }else{
     
        $user_id = $_GET['user'];
        
    }

}

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EchoForum - <?php echo ucfirst($page) ?></title>
    <?php include("partials/common.php"); ?>
</head>

<body class="bg-base-200 min-h-screen">

    <?php

    include("partials/header.php");

    include("views/" . $page . ".php");

    include("partials/footer.php");

    include("partials/toast.php");

    ?>


    <script src="js/app.js"></script>
    <script src="js/helper.js"></script>

    <?php echo '<script src="js/' . $page . '.js"></script>'; ?>

</body>

</html>