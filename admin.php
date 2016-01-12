<?php 

session_start();

require(__DIR__."/congig/db.php");

check_logged_in();

if($_SESSION["user"]["role"] !== "admin"){
    echo "Vous vous êtes égaré ?";
    header("HTTP/1.0 403 Forbidden");
    die();
}
?>