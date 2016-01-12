<?php 

session_start();

require(__DIR__."/functions.php");

check_logged_in();
print_r($_SESSION);
if($_SESSION["user"]["role"] !== "admin"){
    echo "Vous vous êtes égaré ?";
    header("HTTP/1.0 403 Forbidden");
    die();
}
?>