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
        <nav class="nav nav-tabs" id="profile-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-edit-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-expanded="true"><i class="fa fa-address-card-o" aria-hidden="true"></i> แก้ไขข้อมูลส่วนตัว</a>
            <a class="nav-item nav-link" id="nav-password-tab" data-toggle="tab" href="#nav-password" role="tab" aria-controls="nav-password"><i class="fa fa-lock" aria-hidden="true"></i> เปลี่ยนรหัสผ่าน</a>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <!-- Edit Profile -->
            <div class="tab-pane show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <form id="edit_profile_form">
                    <div class="card mt-3">
                        <div class="card-body">
                            <!-- Username -->
                            <div class="form-group row">
                                <label for="username_label" class="col-sm-2 col-form-label">ชื่อบัญชี</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="username_label" value="<?php echo $USER_NAME; ?>" readonly>
                                </div>
                            </div>
                            <!-- Full name -->
                            <div class="form-group row">
                                <label for="first_name_input" class="col-sm-2 col-form-label">ชื่อ-นามสกุล</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="first_name_input" placeholder="ชื่อ">
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="last_name_input" placeholder="นามสกุล">
                                </div>
                            </div>
                            <!-- ID Card -->
                            <div class="form-group row">
                                <label for="id_card_input" class="col-sm-2 col-form-label">เลขบัตรประชาชน</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="id_card_input" placeholder="หมายเลขบัตรประชาชน">
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="form-group row">
                                <label for="email_input" class="col-sm-2 col-form-label">อีเมล</label>
                                <div class="col-sm-5">
                                    <input type="email" class="form-control" id="email_input" placeholder="อีเมล">
                                </div>
                            </div>
                            <!-- Position -->
                            <div class="form-group row">
                                <label for="position_input" class="col-sm-2 col-form-label" >ตำแหน่ง</label>
                                <div class="col-sm-5">
                                    <select class="custom-select form-control" id="position_input">
                                        <option selected>- เลือกตำแหน่ง -</option>
                                    <?php
                                    $db = new Database();
                                    if($db->isConnected()){
                                        $sql = "SELECT * FROM tb_position ORDER BY id";
                                        $db->query($sql);
                                        $db->execute();
                                        if($db->rowCount() > 0){
                                            $result = $db->resultSet();
                                            foreach($result as $row){
                                                $pos_id = $row["id"];
                                                $pos_name = $row["position_name"];
                                                echo "<option value='$pos_id'>$pos_name</option>";
                                            }
                                        }
                                    }
                                    $db->close();
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Level -->
                            <div class="form-group row">
                                <label for="position_input" class="col-sm-2 col-form-label" >ระดับ</label>
                                <div class="col-sm-5">
                                    <select class="custom-select form-control" id="position_input">
                                        <option selected>- เลือกระดับ -</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer text-center">
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


<?php include_once "include/footer.php"; ?>
<?php include_once "include/footer_end.php"; ?>
