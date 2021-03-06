<?php

    // check session, if required
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    if(!isset($_SESSION['user_id']) || !isset($_SESSION['username'])){
        // require login
        // redirect to
        header("Location: index.php");
        die();
    }

    // Menu and Sub menu
    define("PAGE_MENU_INDEX",0);
    define("PAGE_SUBMENU_INDEX",0);

    // Breadcrumb Setting
    // array("title"=>"link")
    $PAGE_BREAD_CRUMB = array();
    
    // print_r($_SESSION);
?>

<?php include_once "include/header.php"; ?>
<?php include_once "include/header_end.php"; ?>

<!-- Content -->
<?php
    if($USER_LOGIN){
        include_once "main_m1.php";     // display main page of normal member
        include_once "main_m2.php";     // display main page of resident member
        include_once "main_admin.php";  // display main page of admin
    }
?>

</div>
<!-- End Content (end container div) -->

<?php include_once "include/footer.php"; ?>

<?php
    if($USER_LOGIN){
        include_once "main_m1_script.php";    
        //include_once "main_m2_script.php";    
        //include_once "main_admin_script.php";
    }
?>

<?php include_once "include/footer_end.php"; ?>