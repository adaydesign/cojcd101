<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }  

    $USER_LOGIN = false;
    if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){

        // include_once "model/database.class.php";


    }else{
        // ...
    }
?>