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
    $PAGE_BREAD_CRUMB = array();
?>

<?php include_once "include/header.php"; ?>
<?php include_once "include/header_end.php"; ?>

<!-- Content-->
<div class="row">

    <div class="col-12 col-md-3">
        <div class="card border-0">
            <div class="card-body text-center">
                <img src="assets/images/default_profile_pic.png" class="rounded-circle w-75">
                <p class='h4 text-primary mt-2'><?php echo $USER_DISPLAY_NAME;?></p>
                <p class='text-secordary'><?php echo $USER_STATE_LABEL;?></p>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไขข้อมูล</btn>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-9 mt-3">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
            <i class="fa fa-address-card-o" aria-hidden="true"></i> ข้อมูลส่วนบุคคล
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-md-4">ชื่อ-นามสกุล</dt>
                    <dd class="col-md-8">..</dd>
                    
                    <dt class="col-md-4">หมายเลขบัตรประชาชน</dt>
                    <dd class="col-md-8">..</dd>

                    <dt class="col-md-4">หมายเลขโทรศัพท์</dt>
                    <dd class="col-md-8">..</dd>

                    <dt class="col-md-4">อีเมล</dt>
                    <dd class="col-md-8">..</dd>

                    <dt class="col-md-4">ตำแหน่ง</dt>
                    <dd class="col-md-8">..</dd>

                    <dt class="col-md-4">ระดับ</dt>
                    <dd class="col-md-8">..</dd>

                </dl>
            </div>
        </div>
    </div>
 

</div>
<!-- Content -->

<?php include_once "include/footer.php"; ?>
<?php include_once "include/footer_end.php"; ?>
