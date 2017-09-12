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
        tb_reserve_form.form_status,
        tb_reserve_form.approver_note,
        tb_reserve_form.approve_date,
        tb_users.id AS user_id, 
        tb_users.first_name,
        tb_users.last_name,
        tb_users.id_card,
        tb_users.tel,
        tb_users.level_id,
        tb_users.position_id,
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
                $rs = $db->singleResult();
                
                $reserve_form_id        = $rs["reserve_form_id"];
                $reserve_form_status    = $rs["form_status"];
                $reserve_form_approver_note = $rs["approver_note"];
                $reserve_form_approve_date  = $rs["approve_date"];
                $register_date          = $rs["register_date"];
                $marry_status           = $rs["marry_status"];
                $spouse_first_name      = $rs["spouse_first_name"];
                $spouse_last_name       = $rs["spouse_last_name"];
                $spouse_position        = $rs["spouse_position"];
                $spouse_office          = $rs["spouse_office"];
                $num_child              = $rs["num_child"];
                $address                = $rs["address"];
                $house_status           = $rs["house_status"];
                $house_owner            = $rs["house_owner"];
                $path_copy_officer_card = $rs["path_copy_officer_card"];
                $path_copy_census       = $rs["path_copy_census"];
                $path_copy_marriage_license = $rs["path_copy_marriage_license"];
                $path_copy_changed_name     = $rs["path_copy_changed_name"];
                $path_copy_current_census   = $rs["path_copy_current_census"]; 
                $r_user_id              = $rs["user_id"]; 
                $r_user_first_name      = $rs["first_name"];
                $r_user_last_name       = $rs["last_name"];
                $r_user_id_card         = $rs["id_card"];
                $r_user_tel             = $rs["tel"];
                $r_user_level_id        = $rs["level_id"];
                $r_user_position_id     = $rs["position_id"];
                $r_user_office_id       = $rs["office_id"];
                $r_user_position_name   = $rs["position_name"];
                $r_user_level_name      = $rs["level_name"];
                $r_user_office_name     = $rs["office_name"];
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
                <dl class="row mb-0">
                    <dt class="col-md-4">ชื่อ-นามสกุล ผู้ยื่นคำร้อง</dt>
                    <dd class="col-md-8"><?php echo $r_user_first_name." ".$r_user_last_name;?></dd>
                    
                    <dt class="col-md-4">หมายเลขบัตรประชาชน</dt>
                    <dd class="col-md-8"><?php echo $r_user_id_card;?></dd>

                    <dt class="col-md-4">หมายเลขโทรศัพท์</dt>
                    <dd class="col-md-8"><?php echo $r_user_tel;?></dd>

                    <dt class="col-md-4">สังกัด</dt>
                    <dd class="col-md-8"><?php echo $r_user_office_name;?></dd>

                    <dt class="col-md-4">ตำแหน่ง</dt>
                    <dd class="col-md-8"><?php echo $r_user_position_name.$r_user_level_name;?></dd>

                    <dt class="col-md-4">วันที่ยื่นคำร้อง</dt>
                    <dd class="col-md-8"><?php echo getDateThai($register_date);?></dd>
                </dl>
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
                <dl class="row mb-0">
                    <dt class="col-md-4">สถานะสมรส</dt>
                    <dd class="col-md-8"><?php
                        $marry_stext = array("โสด","สมรส (จดทะเบียน)","สมรส (ไม่จดทะเบียน)");
                        echo $marry_stext[$marry_status];
                    ?>
                    </dd>
                    <?php
                    if($marry_status!=0){
                    ?>
                        <dt class="col-md-4">ชื่อคู่สมรส</dt>
                        <dd class="col-md-8"><?php echo $spouse_first_name." ".$spouse_last_name;?></dd>

                        <dt class="col-md-4">ตำแหน่ง</dt>
                        <dd class="col-md-8"><?php echo $spouse_position;?></dd>

                        <dt class="col-md-4">สังกัด</dt>
                        <dd class="col-md-8"><?php echo $spouse_office;?></dd>

                        <dt class="col-md-4">จำนวนบุตร</dt>
                        <dd class="col-md-8"><?php echo $num_child > 0? $num_child." คน":"";?>

                        </dd>
                    <?php
                    }   ?>

                    <dt class="col-md-4">ที่อยู่ปัจจุบัน</dt>
                    <dd class="col-md-8"><?php echo $address;?></dd>

                    <dt class="col-md-4">ซึ่งบ้านดังกล่าวเป็นของ</dt>
                    <dd class="col-md-8"><?php 
                        $house_status_label = array("ข้าพเจ้า","คู่สมรส","บุตร");
                        echo $house_status_label[$house_status];
                    ?>
                    </dd>

                    <dt class="col-md-4">โดยเป็น</dt>
                    <dd class="col-md-8"><?php echo $house_owner;?></dd>

                </dl>
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
            <?php
                $db = new Database();
                if($db->isConnected()){
                    $sql = "SELECT tb_building.building_name 
                    FROM tb_building_select
                    INNER JOIN tb_building ON tb_building.id=tb_building_select.building_id
                    WHERE tb_building_select.reserve_form_id=:reserve_form_id";
                
                    $db->query($sql);
                    $db->bind(":reserve_form_id",base64_decode($rsvform_id));
                    if($db->execute()){
                        $result = $db->resultSet();
                        foreach($result AS $row){
                            echo "<text><i class='fa fa-home' aria-hidden='true'></i> ".$row["building_name"]."</text><br>";
                        }
                    }
                }
                $db->close();
            ?>
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
                <dl class="row mb-0">
                <?php
                    if(!empty($path_copy_officer_card)){
                        echo "<dt class='col-md-4'>สำเนาบัตรข้าราชการ</dt>";
                        echo "<dd class='col-md-8'><a href='pdf_view.php?file=".base64_encode($path_copy_officer_card)."' target='_blank'><i class='fa fa-paperclip' aria-hidden='true'></i> ดูเอกสาร</a></dd>";
                    }
                    if(!empty($path_copy_census)){
                        echo "<dt class='col-md-4'>สำเนาทะเบียนบ้านของผู้ยื่น</dt>";
                        echo "<dd class='col-md-8'><a href='pdf_view.php?file=".base64_encode($path_copy_census)."' target='_blank'><i class='fa fa-paperclip' aria-hidden='true'></i> ดูเอกสาร</a></dd>";
                    }
                    if(!empty($path_copy_marriage_license)){
                        echo "<dt class='col-md-4'>สำเนาทะเบียนสมรส</dt>";
                        echo "<dd class='col-md-8'><a href='pdf_view.php?file=".base64_encode($path_copy_marriage_license)."' target='_blank'><i class='fa fa-paperclip' aria-hidden='true'></i> ดูเอกสาร</a></dd>";
                    }
                    if(!empty($path_copy_changed_name)){
                        echo "<dt class='col-md-4'>สำเนาใบเปลี่ยนชื่อ</dt>";
                        echo "<dd class='col-md-8'><a href='pdf_view.php?file=".base64_encode($path_copy_changed_name)."' target='_blank'><i class='fa fa-paperclip' aria-hidden='true'></i> ดูเอกสาร</a></dd>";
                    }
                    if(!empty($path_copy_current_census)){
                        echo "<dt class='col-md-4'>สำเนาทะเบียนบ้านที่อยู่ตามอาศัย</dt>";
                        echo "<dd class='col-md-8'><a href='pdf_view.php?file=".base64_encode($path_copy_current_census)."' target='_blank'><i class='fa fa-paperclip' aria-hidden='true'></i> ดูเอกสาร</a></dd>";
                    }
                ?>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <i class="fa fa-file-text-o" aria-hidden="true"></i> ตรวจสอบเอกสาร (สำหรับผู้ดูแลระบบ)
            </div>
            <form id="form_approve_req_doc">
                <div class="card-body">
                    <!-- Check Box ตรวจสอบ -->
                    <div class="form-group row">
                        <label for="" class="col-lg-3 col-form-label">ข้อมูลคำร้องขอ</label>
                        <div class="col-lg-5">
                            <select class="custom-select form-control" id="approve_data" name="approve_data">
                                <option value="0">- เลือก -</option>
                                <option value="1">ครบถ้วนสมบูรณ์</option>
                                <option value="2">ไม่ครบถ้วน</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="approve_doc" class="col-lg-3 col-form-label">เอกสารประกอบ</label>
                        <div class="col-lg-5">
                            <select class="custom-select form-control" id="approve_doc" name="approve_doc">
                                <option value="0">- เลือก -</option>
                                <option value="1">ครบถ้วนสมบูรณ์</option>
                                <option value="2">ไม่ครบถ้วน</option>
                            </select>
                        </div>
                    </div>
                    <?php
                        if($reserve_form_status==7){ ?>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">หมายเหตุการอนุมัติครั้งก่อน</label>
                            <label class="col-lg-9 col-form-label text-danger"><?php echo $reserve_form_approver_note." <small>(ตรวจสอบวันที่ ".getDateThai($reserve_form_approve_date,true).")</small>";?></label>
                        </div>
                    <?php        
                        } ?>
                </div>
                <div class="card-footer text-center">
                    <input type="hidden" name="rsv_frm_id" value="<?php echo base64_encode($reserve_form_id);?>">
                    <input type="hidden" name="approver_id" value="<?php echo base64_encode($USER_ID);?>">
                    <button type="submit" class="btn btn-success" name="approve_req_btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึกการตรวจสอบ/อนุมัติ คำร้อง</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Content -->

<?php include_once "include/footer.php"; ?>

<script>

    $(function(){

        // send document
        $("#form_approve_req_doc").submit(function(event){
          // Stop form from submitting normally
          event.preventDefault();

          var url_link = "action/act_approve_rsvfrm.php";
          var values   = $(this).serialize();

          $.ajax({
              url : url_link,
              type: "POST",
              data: values,
              success: function(response){
                console.log(response);
                var obj = JSON.parse(response);

                
                $.notify({
                    title: ">",
                    message: obj.message
                },{
                    type: obj.result?'success':'danger'
                });

                if(obj.result){
                    // redirect to user_profile
                    window.setTimeout(function() {
                        window.location.replace("admin_list_req_rsvfrm.php");
                    },1500);
                }
              },
              error: function(jqXHR, textStatus, errorThrown){
                  console.log(textStatus, errorThrown);
              }
          });

        });

    });
</script>

<?php include_once "include/footer_end.php"; ?>
