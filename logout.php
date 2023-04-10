<?php 

session_start();
unset($_SESSION['user_data']);
session_destroy();
header('location:login.php');

?>