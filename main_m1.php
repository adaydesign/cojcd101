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

                    <dt class="col-12 col-sm-4">การเชื่อมโยง LINE Account</dt>
                    <dd class="col-5"><?php echo $u_completed_line; ?></dd>
                    <dd class="col-2"><button class="btn btn-sm  btn-info"><i class="fa fa-cog" aria-hidden="true"></i> ตั้งค่า</button></dd>

                    <dt class="col-12 col-sm-4">คำร้องขอเข้าพักอาศัยฯ</dt>
                    <dd class="col-5">..</dd>
                    <dd class="col-2"><a href="send_reserve_form.php" class="btn btn-sm btn-info"><i class="fa fa-share-square-o" aria-hidden="true"></i> ยื่นคำร้องขอเข้าพัก</a></dd>

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
                    <dd class="col-8">..</dd>
                    
                    <dt class="col-4">วันที่ยื่นคำร้อง</dt>
                    <dd class="col-8">..</dd>

                    <dt class="col-4">อาคารชุดพักอาศัยที่เลือก</dt>
                    <dd class="col-8">..</dd>

                    <dt class="col-12 col-sm-4">สถานะการยื่นคำร้อง</dt>
                    <dd class="col-5">..</dd>
                    <dd class="col-2"><button class="btn btn-sm btn-info"><i class="fa fa-check-square-o" aria-hidden="true"></i> ยืนยัน/ยกเลิกคำร้อง</button></dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Order of Reservation -->
<div class="row mt-3">    
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-bars" aria-hidden="true"></i> ลำดับผู้รอจัดสรรเข้าพักอาศัยอาคารที่พักข้าราชการศาลยุติธรรมฯ
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-4">เลขที่ใบคำร้อง</dt>
                    <dd class="col-8">..</dd>
                    
                    <dt class="col-4">วันที่ยื่นคำร้อง</dt>
                    <dd class="col-8">..</dd>

                    <dt class="col-4">อาคารชุดพักอาศัย</dt>
                    <dd class="col-8">..</dd>

                    <dt class="col-4">ลำดับที่</dt>
                    <dd class="col-8">..</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<?php
} ?>