<?php
    // check session, if required
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    if(!isset($_SESSION['user_id'])){
        // require login
        // redirect to
        header("Location: index.php");
        die();
    }
    
    // Menu and Sub menu
    define("PAGE_MENU_INDEX",5);
    define("PAGE_SUBMENU_INDEX",0);

    // Breadcrumb Setting
    // array("title"=>"link")
    $PAGE_BREAD_CRUMB = array("ข้อมูลส่วนตัว"=>"profile.php","แก้ไขข้อมูลส่วนตัว"=>"");
?>

<?php include_once "include/header.php"; ?>
<?php include_once "include/header_end.php"; ?>

<!-- Content-->
<div class="row">
    
</div>
<!-- Content -->

<?php include_once "include/footer.php"; ?>
<?php include_once "include/footer_end.php"; ?>
