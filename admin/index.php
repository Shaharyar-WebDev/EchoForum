<?php
session_start();

require("../config/connection.php");

if(!isset($_SESSION['user_id']) || !$_SESSION['role'] == 1){

    header("location: ../public/");

}

if(isset($_GET['logout']) && ($_GET['logout'] == 'true')){

    session_unset();
    session_destroy();
    header("location: ../public/");

};

$allowed_pages = ['threads', 'users', 'replies', 'categories', 'dashboard', '404', '403'];

if (!isset($_GET['page']) || empty($_GET['page']) || intval($_GET['page'])) {

    header("location: .?page=dashboard");
} else {
    if (in_array($_GET['page'], $allowed_pages)) {

        $page = $_GET['page'];
    }else{
    
        $page = '404';

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EchoForum - Admin</title>
    <?php
    include("../public/partials/common.php");
    ?>
    <style>
        .fake-disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
    </style>
</head>
<body>
<?php
    include("partials/header.php");

    include('views/' . $page . '.php');

    include("../public/partials/footer.php");

    include("partials/toast.php");
?>

<script src="js/app.js"></script>
<script src="js/helper.js"></script>

<?php

try{
    echo "<script src='js/".$page.".js'></script>";
}catch(Exception $e){

}
?>

</body>

</html>