<?php
session_start();

if(!isset($_SESSION["userid"]) || $_SESSION["userid"] !== false){
    include '../html/Homepage.html';
}else{
    header("location: login.php");
   exit;
}
?>
