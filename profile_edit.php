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

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header pb-0 border-bottom-0">
                <nav class="nav nav-tabs" id="profile-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-edit-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-expanded="true"><i class="fa fa-address-card-o" aria-hidden="true"></i> แก้ไขข้อมูลส่วนตัว</a>
                    <a class="nav-item nav-link" id="nav-password-tab" data-toggle="tab" href="#nav-password" role="tab" aria-controls="nav-password"><i class="fa fa-lock" aria-hidden="true"></i> เปลี่ยนรหัสผ่าน</a>
                </nav>
            </div>
            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <!-- Edit Profile -->
                    <?php
                        // user profile
                        $db0 = new Database();
                        $sql0 = "SELECT * FROM tb_users
                                WHERE id=:id";
                        $db0->query($sql0);
                        $db0->bind(":id",$USER_ID);
                        if($db0->execute()){
                            $rs0 = $db0->singleResult();
                            $u_username     = $rs0["username"];
                            $u_f_name       = $rs0["first_name"];
                            $u_l_name       = $rs0["last_name"];
                            $u_id_card      = $rs0["id_card"];
                            $u_pos_id       = $rs0["position_id"];
                            $u_lv_id        = $rs0["level_id"];
                            $u_email        = $rs0["email"];
                            $u_tel          = $rs0["tel"];
                            $u_office_id    = $rs0["office_id"];
                        } 
                        $db0->close();
                    ?>
                    <div class="tab-pane show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <form id="edit_profile_form">
                            <div class="card border-0">
                                <div class="card-body border-0">
                                    <!-- Username -->
                                    <div class="form-group row">
                                        <label for="username_label" class="col-sm-2 col-form-label">ชื่อบัญชี</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="username_label" value="<?php echo $u_username; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- Full name -->
                                    <div class="form-group row">
                                        <label for="first_name_input" class="col-sm-2 col-form-label">ชื่อ-นามสกุล</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="first_name_input" name="first_name_input" value="<?php echo $u_f_name; ?>" placeholder="ชื่อ" maxlength="50" required>
                                        </div>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="last_name_input" name="last_name_input" value="<?php echo $u_l_name; ?>" placeholder="นามสกุล" maxlength="50" required>
                                        </div>
                                    </div>
                                    <!-- ID Card -->
                                    <div class="form-group row">
                                        <label for="id_card_input" class="col-sm-2 col-form-label">เลขบัตรประชาชน</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="id_card_input" name="id_card_input" value="<?php echo $u_id_card; ?>" placeholder="หมายเลขบัตรประชาชน" maxlength="13" required>
                                        </div>
                                    </div>
                                    <!-- Email -->
                                    <div class="form-group row">
                                        <label for="email_input" class="col-sm-2 col-form-label">อีเมล</label>
                                        <div class="col-sm-5">
                                            <input type="email" class="form-control" id="email_input" value="<?php echo $u_email; ?>" placeholder="อีเมล" maxlength="60" readonly>
                                        </div>
                                    </div>
                                    <!-- Tel. -->
                                    <div class="form-group row">
                                        <label for="tel_input" class="col-sm-2 col-form-label">หมายเลขโทรศัพท์</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="tel_input" name="tel_input" value="<?php echo $u_tel; ?>" placeholder="หมายเลขโทรศัพท์" maxlength="20" >
                                        </div>
                                    </div>

                                    <!-- Office -->
                                    <div class="form-group row">
                                        <label for="position_input" class="col-sm-2 col-form-label" >สังกัด</label>
                                        <div class="col-sm-5">
                                            <select class="custom-select form-control" id="office_input" name="office_input">
                                                <option value="0" selected>- เลือกสังกัด -</option>
                                                <?php
                                                    $db = new Database();
                                                    $sql = "SELECT * FROM tb_bkk_courts";
                                                    $db->query($sql);
                                                    if($db->execute()){
                                                        $result = $db->resultSet();
                                                        foreach($result AS $row){
                                                            $court_id    = $row["id"];
                                                            $court_name  = $row["name"];
                                                            $select = $court_id==$u_office_id?" selected":"";
                                                            echo "<option value='".$court_id."' $select>".$court_name."</option>";
                                                        }
                                                    }
                                                    $db->close();
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Position -->
                                    <div class="form-group row">
                                        <label for="position_input" class="col-sm-2 col-form-label" >ตำแหน่ง</label>
                                        <div class="col-sm-5">
                                            <select class="custom-select form-control" id="position_input" name="position_input">
                                                <option value="0" selected>- เลือกตำแหน่ง -</option>
                                                <?php
                                                    $db = new Database();
                                                    $sql = "SELECT * FROM tb_position";
                                                    $db->query($sql);
                                                    if($db->execute()){
                                                        $result = $db->resultSet();
                                                        foreach($result AS $row){
                                                            $position_id    = $row["id"];
                                                            $position_name  = $row["position_name"];
                                                            $select = $position_id==$u_pos_id?" selected":"";
                                                            echo "<option value='".$position_id."' $select>".$position_name."</option>";
                                                        }
                                                    }
                                                    $db->close();
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Level -->
                                    <div class="form-group row">
                                        <label for="level_input" class="col-sm-2 col-form-label" >ระดับ</label>
                                        <div class="col-sm-5" id="div_level_input">
                                            - กรุณาเลือกตำแหน่ง -
                                        </div>
                                    </div>


                                </div>
                                <div class="card-footer text-center">
                                    <input type="hidden" name="user_id" value="<?php echo base64_encode($USER_ID);?>">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i> แก้ไขข้อมูล</button>
                                    <a href="profile.php" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> ยกเลิก</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Change Password -->
                    <div class="tab-pane" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
                        change password
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<?php include_once "include/footer.php"; ?>

<script>
$(function(){

    $("#position_input").change(function(){
        var value    = {"position_id":$(this).val()};
        var url_link = "render/position_level.render.php";
        $.ajax({
            url : url_link,
            type: "POST",
            data: value,
            success: function(response){
                $("#div_level_input").html(response);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    });

    $("#edit_profile_form").submit(function(event){
        event.preventDefault();

        var url_link = "action/act_edit_profile.php";
        var values   = $(this).serialize();

        $.ajax({
            url : url_link,
            type: "POST",
            data: values,
            success: function(response){
                var result = JSON.parse(response);
                $.notify({
                    title: "การแก้ไขข้อมูลส่วนตัว",
                    message: result.message
                },{
                    type: result.result?'success':'danger'
                });

                if(result.result){
                    // redirect to user_profile
                    window.setTimeout(function() {
                        window.location.replace("profile.php");
                    },1500);
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    });


    //
    var a_value    = {"position_id":<?php echo $u_pos_id;?>,"level_id":<?php echo $u_lv_id;?>};
    var a_url_link = "render/position_level.render.php";
    $.ajax({
        url : a_url_link,
        type: "POST",
        data: a_value,
        success: function(response){
            $("#div_level_input").html(response);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(textStatus, errorThrown);
        }
    });

    
});


</script>


<?php include_once "include/footer_end.php"; ?>
