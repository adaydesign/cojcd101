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
    define("PAGE_MENU_INDEX",4);
    define("PAGE_SUBMENU_INDEX",1);

    // Breadcrumb Setting
    // array("title"=>"link")
    $PAGE_BREAD_CRUMB = array(  "ผู้ดูแลระบบ"=>"index.php",
                                "รายการคำร้องขอเข้าพักฯ"=>"admin_list_req_rsvfrm.php",
                                "ตรวจสอบคำร้องขอและอนุมัติการขอเข้าพัก"=>"");
?>

<?php include_once "include/header.php"; ?>
<?php include_once "include/header_end.php"; ?>

<?php 
    //check parameters
    $rsvform_id = filter_input(INPUT_POST,"rsvform_id",FILTER_SANITIZE_SPECIAL_CHARS);
    //check permision
    if(!in_array($USER_STATE,[10,11]) || empty($rsvform_id)){
        // require admin login
        // redirect to
        header("Location: index.php");
        die();
    }
?>

<?php

    $db = new Database();
    if($db->isConnected()){
        $sql = "SELECT tb_reserve_form.id AS reserve_form_id,
        tb_reserve_form.register_date,
        tb_reserve_form.marry_status ,
        tb_reserve_form.spouse_first_name ,
        tb_reserve_form.spouse_last_name ,
        tb_reserve_form.spouse_position ,
        tb_reserve_form.spouse_office ,
        tb_reserve_form.num_child ,
        tb_reserve_form.address ,
        tb_reserve_form.house_status ,
        tb_reserve_form.house_owner ,
        tb_reserve_form.path_copy_officer_card ,
        tb_reserve_form.path_copy_census ,
        tb_reserve_form.path_copy_marriage_license ,
        tb_reserve_form.path_copy_changed_name ,
        tb_reserve_form.path_copy_current_census ,
        tb_users.id AS user_id, 
        tb_users.first_name,
        tb_users.last_name,
        tb_users.level_id,tb_users.position_id,
        tb_users.office_id,
        tb_position.position_name,
        tb_level.level_name,
        tb_bkk_courts.name AS office_name
        FROM tb_reserve_form
        INNER JOIN tb_users ON tb_users.id=tb_reserve_form.user_id
        INNER JOIN tb_position ON tb_position.id=tb_users.position_id
        INNER JOIN tb_level ON tb_level.id=tb_users.level_id
        INNER JOIN tb_bkk_courts ON tb_bkk_courts.id=tb_users.office_id
        WHERE tb_reserve_form.id=:tb_reserve_form_id";


        $db->query($sql);
        $db->bind(":tb_reserve_form_id",base64_decode($rsvform_id));
        if($db->execute()){
            if($db->rowCount()>0){
                $rs = $db->singleRow();
                /*
                reserve_form_id,
                register_date,
                marry_status ,
                spouse_first_name ,
                spouse_last_name ,
                tbspouse_position ,
                spouse_office ,
                num_child ,
                address ,
                house_status ,
                house_owner ,
                path_copy_officer_card ,
                path_copy_census ,
                path_copy_marriage_license ,
                path_copy_changed_name ,
                tpath_copy_current_census ,
                user_id, 
                first_name,
                last_name,
                level_id,
                position_id,
                office_id,
                position_name,
                level_name,
                office_name*/
            }
        }
    }
    $db->close();


?>

<!-- Content-->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> ข้อมูลคำร้องขอเข้าพักฯ
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> ข้อมูลคู่สมรสและที่อยู่ปัจจุบัน
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> ข้อมูลอาคารที่พักที่เลือก
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> เอกสารประกอบ
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> การอนุมัติ
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>
</div>

<!-- Content -->

<?php include_once "include/footer.php"; ?>
<?php include_once "include/footer_end.php"; ?>
