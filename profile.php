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
                <a href="profile_edit.php"  class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไขข้อมูล</a>
            </div>
        </div>
    </div>

    <?php
        // user profile
        $db0 = new Database();
        $sql0 = "SELECT  username,first_name,last_name,id_card,position_id,level_id,email,tel,
                         tb_level.level_name        AS level_name,
                         tb_level.level_group       AS level_group,
                         tb_position.position_name  AS position_name,
                         tb_bkk_courts.name         AS office_name
                 FROM tb_users
                 INNER JOIN tb_position     ON tb_position.id = tb_users.position_id 
                 INNER JOIN tb_level        ON tb_level.id = tb_users.level_id
                 INNER JOIN tb_bkk_courts   ON tb_bkk_courts.id = tb_users.office_id
                 WHERE tb_users.id=:id";
        $db0->query($sql0);
        $db0->bind(":id",$USER_ID);
        if($db0->execute()){
            $rs0 = $db0->singleResult();
            $u_username     = $rs0["username"];
            $u_f_name       = $rs0["first_name"];
            $u_l_name       = $rs0["last_name"];
            $u_id_card      = $rs0["id_card"];
            $u_pos_id       = $rs0["position_id"];
            $u_pos_name     = $rs0["position_name"];
            $u_lv_id        = $rs0["level_id"];
            $u_lv_name      = $rs0["level_name"];
            $u_lv_group     = $rs0["level_group"];
            $u_email        = $rs0["email"];
            $u_tel          = $rs0["tel"];
            $u_office          = $rs0["office_name"];
        } 
        $db0->close();
    ?>
    <div class="col-12 col-md-9 mt-3">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
            <i class="fa fa-address-card-o" aria-hidden="true"></i> ข้อมูลส่วนบุคคล
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-md-4">ชื่อ-นามสกุล</dt>
                    <dd class="col-md-8"><?php echo $u_f_name." ".$u_l_name;?></dd>
                    
                    <dt class="col-md-4">หมายเลขบัตรประชาชน</dt>
                    <dd class="col-md-8"><?php echo $u_id_card;?></dd>

                    <dt class="col-md-4">หมายเลขโทรศัพท์</dt>
                    <dd class="col-md-8"><?php echo $u_tel;?></dd>

                    <dt class="col-md-4">อีเมล</dt>
                    <dd class="col-md-8"><?php echo $u_email;?></dd>

                    <dt class="col-md-4">สังกัด</dt>
                    <dd class="col-md-8"><?php echo $u_office;?></dd>

                    <dt class="col-md-4">ตำแหน่ง</dt>
                    <dd class="col-md-8"><?php echo $u_pos_name;?></dd>

                    <dt class="col-md-4">ระดับ</dt>
                    <dd class="col-md-8"><?php echo $u_lv_name;?></dd>

                </dl>
            </div>
        </div>
    </div>
 

</div>
<!-- Content -->

<?php include_once "include/footer.php"; ?>

<?php include_once "include/footer_end.php"; ?>
