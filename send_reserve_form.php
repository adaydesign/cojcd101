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
    define("PAGE_MENU_INDEX",3);
    define("PAGE_SUBMENU_INDEX",0);

    // Breadcrumb Setting
    // array("title"=>"link")
    $PAGE_BREAD_CRUMB = array("สถานะการยื่นคำร้อง"=>"xx","ยื่นคำร้องขอเข้าพัก"=>"");
?>

<?php include_once "include/header.php"; ?>

<link href="http://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>

<?php include_once "include/header_end.php"; ?>

<!-- Content-->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-home" aria-hidden="true"></i> คำร้องขอเข้าพักอาศัยอาคารที่พักข้าราชการศาลยุติธรรมในเขตกรุงเทพมหานคร
            </div>
            <?php
                $db = new Database();
                if($db->isConnected()){
                    $sql = "SELECT  first_name,last_name,tel,email,office_id,position_id,level_id,
                                    tb_position.position_name AS position_name,
                                    tb_level.level_name AS level_name,
                                    tb_bkk_courts.name AS court_name  
                            FROM tb_users
                            INNER JOIN tb_position ON tb_position.id=tb_users.position_id
                            INNER JOIN tb_level ON tb_level.id=tb_users.level_id
                            INNER JOIN tb_bkk_courts ON tb_bkk_courts.id=tb_users.office_id
                            WHERE tb_users.id=:user_id";
                    $db->query($sql);
                    $db->bind(":user_id",$USER_ID);
                    if($db->execute()){
                        $rs = $db->singleResult();
                        $user_full_name = $rs["first_name"]." ".$rs["last_name"];
                        $user_tel       = $rs["tel"];
                        $user_email     = $rs["email"];
                        $position_name  = $rs["position_name"];
                        $level_name     = $rs["level_name"];
                        $office_name    = $rs["court_name"];
                    }
                }
                $db->close();
            
            ?>
            <form id="send_reserve_form" method="POST">
                <div class="card-body">
                    <!-- Full Name -->
                    <div class="form-group row">
                        <label for="user_full_name_label" class="col-sm-2 col-form-label">ชื่อ</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="user_full_name_label" value="<?php echo $user_full_name;?>" readonly>
                        </div>
                    </div>
                    <!-- Position Name -->
                    <div class="form-group row">
                        <label for="user_position_label" class="col-sm-2 col-form-label">ตำแหน่ง</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="user_position_label" value="<?php echo $position_name;?>" readonly>
                        </div>
                    </div>
                    <!-- Level Name -->
                    <div class="form-group row">
                        <label for="user_level_label" class="col-sm-2 col-form-label">ระดับ</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="user_level_label" value="<?php echo $level_name;?>" readonly>
                        </div>
                    </div>
                    <!-- Office Name -->
                    <div class="form-group row">
                        <label for="user_office_label" class="col-sm-2 col-form-label">สังกัด</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="user_office_label" value="<?php echo $office_name;?>" readonly>
                        </div>
                    </div>
                    <!-- Phone -->
                    <div class="form-group row">
                        <label for="user_tel_label" class="col-sm-2 col-form-label">โทรศัพท์</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="user_tel_label" value="<?php echo $user_tel;?>" readonly>
                        </div>
                    </div>
                    <hr>
                    <!-- ------------------------------------------------------- -->
                    <!-- Marriage Status -->
                    <div class="form-group row">
                        <label for="user_marriage_status" class="col-sm-2 col-form-label">สถานะภาพ</label>
                        <div class="col-sm-5">
                            <select class="custom-select form-control" id="user_marriage_status" name="user_marriage_status">
                                <option value="-1" selected>- เลือกสถานะภาพ -</option>
                                <option value="0">โสด</option>
                                <option value="1">สมรส (จดทะเบียน)</option>
                                <option value="2">สมรส (ไม่จดทะเบียน)</option>
                            </select>
                        </div>
                    </div>
                    <!-- spouse_first_name last_name -->
                    <div class="form-group row div_spouse_info" style="display:none">
                        <label for="sp_first_name_input" class="col-sm-2 col-form-label">คู่สมรสชื่อ</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="sp_first_name_input" name="sp_first_name_input" value="" placeholder="ชื่อ" maxlength="50" >
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="sp_last_name_input" name="sp_last_name_input" value="" placeholder="นามสกุล" maxlength="50" >
                        </div>
                    </div>
                    <!-- spouse_position -->
                    <div class="form-group row div_spouse_info"  style="display:none">
                        <label for="spouse_position_label" class="col-sm-2 col-form-label">ตำแหน่ง</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="spouse_position_label" name="spouse_position_label" maxlength="50" value="">
                        </div>
                    </div>
                    <!-- spouse_office -->
                    <div class="form-group row div_spouse_info"  style="display:none">
                        <label for="spouse_office_label" class="col-sm-2 col-form-label">สังกัด</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="spouse_office_label" name="spouse_office_label"  maxlength="50" value="">
                        </div>
                    </div>
                    <!-- num_child -->
                    <div class="form-group row">
                        <label for="num_child_label" class="col-sm-2 col-form-label">จำนวนบุตร(คน)</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" id="num_child_label" name="num_child_label"  min="0" max="15" value="0">
                        </div>
                    </div>
                    <!-- address -->
                    <div class="form-group row">
                        <label for="num_child_label" class="col-sm-2 col-form-label">ปัจจุบันมีชื่ออยู่ในทะเบียนบ้าน</label>
                        <div class="col-sm-5">
                            <textarea class="form-control" rows="2" id="address" name="address"></textarea>
                        </div>
                    </div>
                    <!-- owner house -->
                    <div class="form-group row">
                        <label for="house_owner_status" class="col-sm-2 col-form-label">ซึ่งบ้านดังกล่าวเป็นของ</label>
                        <div class="col-sm-5">
                            <select class="custom-select form-control" id="house_owner_status" name="house_owner_status">
                                <option value="-1" selected>- เลือกเจ้าของบ้าน -</option>
                                <option value="0">ข้าพเจ้า</option>
                                <option value="1">คู่สมรส</option>
                                <option value="2">บุตร</option>
                            </select>
                        </div>
                    </div>
                    <!-- is ?-->
                    <div class="form-group row">
                        <label for="house_owner_is_label" class="col-sm-2 col-form-label">โดยเป็น</label>
                        <div class="col-sm-5">
                            <select class="custom-select form-control" id="house_owner_is_label" name="house_owner_is_label">
                                <option value="-1" selected>- เลือก -</option>
                                <option value="เช่าบ้านอยู่อาศัย">เช่าบ้านอยู่อาศัย</option>
                                <option value="ปลูกบ้านเองในที่เช่า">ปลูกบ้านเองในที่เช่า</option>
                                <option value="บ้านและที่ดินของตนเอง">บ้านและที่ดินของตนเอง</option>
                                <option value="-2">อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-sm-5" id="div_other_house_owner_is" style="display:none">
                            <input type="text" class="form-control" id="other_house_owner_is_label" name="other_house_owner_is_label" value="" placeholder="ชื่อรายการอื่นเพิ่มเติม" maxlength="100" >
                        </div>
                    </div>
                    <hr>
                    <!-- ------------------------------------------------------- -->
                    <!-- select building -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">มีความประสงค์ขอเข้าพักอาศัย</label>
                        <div class="col-sm-6">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="select_building_1" value="1">
                                อาคารที่พักข้าราชการศาลยุติธรรม ซอยเสนานิคม 1
                            </label>
                            <div class="w-100"></div>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="select_building_2" value="1">
                                อาคารที่พักข้าราชการศาลยุติธรรม ขนาด 50 หน่วย (ตลิ่งชัน)
                            </label>
                            <div class="w-100"></div>
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="select_building_3" value="1">
                                อาคารชุดที่พักอาศัยข้าราชการศาลยุติธรรม จำนวน 96 หน่วย (ตลิ่งชัน)
                            </label>
                        </div>
                    </div>
                    <hr>
                    <!-- ------------------------------------------------------- -->
                    <div class="form-group row">
                        <label class="col col-form-label"><i class="fa fa-file-text-o" aria-hidden="true"></i> แนบเอกสารที่เกี่ยวข้องเพื่อประกอบการพิจารณาดังนี้</label>
                    </div>
                    <div class="form-group row">
                    <div id="fileuploader">Upload</div>
                    </div>

                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึกเอกสาร</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> ส่งคำร้อง</button>
                    <button type="reset"  class="btn btn-secondary"><i class="fa fa-undo" aria-hidden="true"></i> รีเซ็ต</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

<?php include_once "include/footer.php"; ?>
<!-- http://hayageek.com/docs/jquery-upload-file.php
     http://simpleupload.michaelcbrook.com/#examples -->
<!--
     <script type="text/javascript" src="lib/simpleUpload/simpleUpload.min.js"></script>
 -->
<script>
    $(function(){

        $("#user_marriage_status").change(function(){
            if($(this).val()>0){
                $(".div_spouse_info").show();
            }else{
                $(".div_spouse_info").hide();
            }
        });

        $("#house_owner_is_label").change(function(){
            if($(this).val()==-2){
                $("#div_other_house_owner_is").show();
            }else{
                $("#div_other_house_owner_is").hide();
            }
        });

        
        $("#fileuploader").uploadFile({
            url:"action/act_upload.php",
            fileName:"myfile"
        });


    });
</script>

<?php include_once "include/footer_end.php"; ?>
