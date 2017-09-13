<?php
if(isset($USER_STATE) && $USER_STATE==0){ // Normal Member ?>

<!-- User Infomation -->
<?php
    // User profile
    $db = new Database();
    if($db->isConnected()){
        $sql = "SELECT * FROM tb_users WHERE id=:id";
        $db->query($sql);
        $db->bind(":id",$USER_ID);
        if($db->execute()){
            $row = $db->singleResult();
            
            $u_username     = $row["username"];
            $u_f_name       = $row["first_name"];
            $u_l_name       = $row["last_name"];
            $u_id_card      = $row["id_card"];
            $u_reg_date     = $row["register_date"];
            $u_line_account = $row["line_account"];
            $u_enable       = $row["enable_status"];

            //Text label
            //complete info
            if(empty($u_id_card)){
                $u_completed_info ="<text class='text-danger'><i class='fa fa-times' aria-hidden='true'></i> ข้อมูลยังไม่สมบูรณ์</text>";
            }else{
                $u_completed_info ="<text class='text-success'><i class='fa fa-check' aria-hidden='true'></i> ข้อมูลสมบูรณ์</text>";
            }
            //group name
            if($row["user_group"]===0){
                $u_group_name     = "ผู้ใช้ทั่วไป";
            }else{
                $u_group_name     = "ผู้ดูแลระบบ";
            }
            //complete line connected
            if(empty($u_line_account)){
                $u_completed_line = "<text class='text-danger'><i class='fa fa-times' aria-hidden='true'></i> ยังไม่ได้เชื่อมต่อ</text>";
            }else{
                $u_completed_line = "<text class='text-success'><i class='fa fa-check' aria-hidden='true'></i> เชื่อมต่อเรียบร้อยด้วยบัญชี $u_line_account</text>";
            }
        }
    }
    $db->close();

    // User Request
    $req_count  = 0;
    $req_num    = "-";
    $req_date   = "-";

    $db2 = new Database();
    if($db2->isConnected()){
        $sql = "SELECT 
            tb_reserve_form.id AS form_id,
            register_date,form_status,approver_note,
            tb_reserve_form_status.status_name
        FROM tb_reserve_form
        INNER JOIN tb_reserve_form_status ON tb_reserve_form_status.id=tb_reserve_form.form_status
        WHERE user_id=:user_id";
        $db2->query($sql);
        $db2->bind(":user_id",$USER_ID);
        if($db2->execute()){
            if($db2->rowCount()>0){
                $req_count = $db2->rowCount();

                $rs2                = $db2->singleResult();
                $req_num            = $rs2["form_id"];
                $req_date           = getDateThai($rs2["register_date"]);
                $req_status         = $rs2['form_status'];
                $req_status_name    = $rs2['status_name'];
                $req_approver_note  = $rs2['approver_note'];
            }
        }
    }
    $db2->close();

?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-address-book-o" aria-hidden="true"></i> ยินดีต้อนรับ
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-4">บัญชีผู้ใช้</dt>
                    <dd class="col-8"><?php echo $u_username;?></dd>
                    
                    <dt class="col-4">กลุ่มผู้ใช้</dt>
                    <dd class="col-8"><?php echo $u_group_name;?></dd>

                    <dt class="col-12 col-sm-4">ข้อมูลส่วนบุคคล</dt>
                    <dd class="col-5"><?php echo $u_completed_info;?></dd>
                    <dd class="col-2"><a href="profile_edit.php" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไขข้อมูลส่วนตัว</a></dd>

                    <dt class="col-12 col-sm-4">คำร้องขอเข้าพักอาศัยฯ</dt>
                    <dd class="col-5">
                    <?php
                        $req_send_btn_style = "";
                        if($req_count==0){
                            echo "ยังไม่ได้ยื่นคำร้องขอเข้าพักฯ";
                        }else{
                            echo "ยื่นคำร้องขอเข้าพักแล้ว";
                            $req_send_btn_style = "display:none";
                        }
                    ?>
                    </dd>
                    <dd class="col-2" style="<?php echo $req_send_btn_style;?>"><a href="send_reserve_form.php" class="btn btn-sm btn-info"><i class="fa fa-share-square-o" aria-hidden="true"></i> ยื่นคำร้องขอเข้าพัก</a></dd>

                    <dt class="col-12 col-sm-4">การเชื่อมต่อ LINE Account</dt>
                    <!--
                    <dd class="col-5"><?php echo $u_completed_line; ?></dd>
                    <dd class="col-2"><button class="btn btn-sm  btn-info"><i class="fa fa-cog" aria-hidden="true"></i> ตั้งค่า</button></dd>
                    -->
                    <dd class="col-5">สแกน QR Code</dd>
                    <dd class="col-2"><img src="assets/images/H5JSnCku4F.png" width="230px" alt="..." class="img-thumbnail"></dd>


                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Reservation Status -->
<div class="row mt-3">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> สถานะการยื่นคำร้องข้อเข้าพักอาศัยอาคารที่พักข้าราชการศาลยุติธรรมฯ
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-4">เลขที่ใบคำร้อง</dt>
                    <dd class="col-8"><?php echo $req_num;?></dd>
                    
                    <dt class="col-4">วันที่ยื่นคำร้อง</dt>
                    <dd class="col-8"><?php echo $req_date;?></dd>

                    <dt class="col-4">อาคารชุดพักอาศัยที่เลือก</dt>
                    <dd class="col-8"><?php
                        if($req_count==0){
                            echo "-";
                        }else{
                            $db = new Database();
                            if($db->isConnected()){
                                $sql = "SELECT tb_building.building_name 
                                FROM tb_building_select
                                INNER JOIN tb_building ON tb_building.id=tb_building_select.building_id
                                WHERE tb_building_select.reserve_form_id=:reserve_form_id";
                            
                                $db->query($sql);
                                $db->bind(":reserve_form_id",$req_num);
                                if($db->execute()){
                                    $result = $db->resultSet();
                                    foreach($result AS $row){
                                        echo "<text><i class='fa fa-home' aria-hidden='true'></i> ".$row["building_name"]."</text><br>";
                                    }
                                }
                            }
                            $db->close();
                        }
                    
                    ?></dd>

                    <?php
                        if($req_count > 0){ ?>
                            <dt class="col-12 col-sm-4" >สถานะการยื่นคำร้อง</dt>
                            <dd class="col-12 col-sm-5" >
                                <?php
                                    //$icon       = $req_status==6?"fa-check":"fa-times";
                                    if($req_status==1){
                                        $icon       = "fa-hourglass-half";
                                        $text_color = "text-warning";
                                    }
                                    else if($req_status==2 ||$req_status==4 ||$req_status==5 ||$req_status==6){
                                        $icon       = "fa-check";
                                        $text_color = "text-success";
                                    }else{
                                        $icon       = "fa-times";
                                        $text_color = "text-danger";
                                    }
                                ?>
                                <text class="text <?php echo $text_color;?>"><i class="fa <?php echo $icon;?>" aria-hidden="true"></i> <?php echo $req_status_name;?></text>
                                <?php 
                                    if($req_status==7){ ?>
                                    <div class="w-100"></div>
                                    <text class="text text-danger"><small><?php echo "หมายเหตุ ".$req_approver_note;?></small></text>
                                <?php
                                    } ?>
                            </dd>
                            
                            <?php
                                $display_confirm = $req_status!=6?"display:none":""; ?>
                            <dt class="col-12 col-sm-4 mt-3" style="<?php echo $display_confirm;?>">ยืนยัน/ยกเลิกคำร้อง</dt>
                            <dd class="col-12 col-sm-5 mt-3" style="<?php echo $display_confirm;?>">
                                <button class="btn btn-sm btn-info"   id="btn_confirm_req" data-reqdoc="<?php echo base64_encode($req_num); ?>" data-comfirm="true"><i class="fa fa-check-square-o" aria-hidden="true"></i> ยืนยันคำร้องฯ</button>
                                <button class="btn btn-sm btn-danger" id="btn_cancel_req"  data-reqdoc="<?php echo base64_encode($req_num); ?>" data-comfirm="false"><i class="fa fa-times" aria-hidden="true"></i> ยกเลิกคำร้องฯ</button>
                            </dd>
                    <?php
                        } ?>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Order of Reservation -->
<!--
<div class="row mt-3">    
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-bars" aria-hidden="true"></i> ลำดับผู้รอจัดสรรเข้าพักอาศัยอาคารที่พักข้าราชการศาลยุติธรรมฯ
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-4">อาคารชุดพักอาศัย</dt>
                    <dd class="col-8">..</dd>

                    <dt class="col-4">ลำดับที่</dt>
                    <dd class="col-8">..</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
-->

<?php
} ?>