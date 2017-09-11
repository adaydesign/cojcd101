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
    $PAGE_BREAD_CRUMB = array("ผู้ดูแลระบบ"=>"index.php","รายการคำร้องขอเข้าพักฯ"=>"");
?>

<?php include_once "include/header.php"; ?>
<?php include_once "include/header_end.php"; ?>

<?php 
    //check permision
    if(!in_array($USER_STATE,[10,11])){
        // require admin login
        // redirect to
        header("Location: index.php");
        die();
    }
?>

<!-- Content-->
<div class="row">
    <div class="col">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <i class="fa fa-clipboard" aria-hidden="true"></i> รายการคำร้องขอเข้าพักอาศัยอาคารที่พักข้าราชการศาลยุติธรรมในเขตกรุงเทพมหานคร
            </div>
            <div class="card-body">
                <?php
                    $db = new Database();
                    if($db->isConnected()){
                        $sql = "SELECT tb_reserve_form.id AS reserve_form_id,
                        tb_users.id AS user_id, 
                        tb_users.first_name,
                        tb_users.last_name,
                        tb_users.level_id,tb_users.position_id,
                        tb_users.office_id,
                        tb_reserve_form.register_date,
                        tb_position.position_name,
                        tb_level.level_name,
                        tb_bkk_courts.name AS office_name
                        FROM tb_reserve_form
                        INNER JOIN tb_users ON tb_users.id=tb_reserve_form.user_id
                        INNER JOIN tb_position ON tb_position.id=tb_users.position_id
                        INNER JOIN tb_level ON tb_level.id=tb_users.level_id
                        INNER JOIN tb_bkk_courts ON tb_bkk_courts.id=tb_users.office_id
                        ORDER BY tb_reserve_form.register_date";

                        $db->query($sql);
                        if($db->execute()){
                        ?>
                            <p class="text-center">จำนวนรายการคำร้องขอเข้าพักอาศัยฯ ทั้งหมด <?php echo $db->rowCount();?> รายการ</p>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class='text-center'>ลำดับ</th>
                                        <th class='text-center'>ชื่อ-นามสกุล ผู้ยื่นคำร้อง</th>
                                        <th class='text-center'>ตำแหน่ง</th>
                                        <th class='text-center'>ระดับ</th>
                                        <th class='text-center'>สังกัด</th>
                                        <th class='text-center'>วันที่ยื่นเอกสาร</th>
                                        <th class='text-center'>ตรวจสอบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($db->rowCount()>0){
                                        $result = $db->resultSet();
                                        $order = 0;
                                        foreach($result AS $row){
                                            $r_reserve_form_id    = base64_encode($row["reserve_form_id"]);
                                            $r_user_id            = $row["user_id"];
                                            $r_first_name         = $row["first_name"];
                                            $r_last_name          = $row["last_name"];
                                            $r_register_date      = $row["register_date"];
                                            $r_position_name      = $row["position_name"];
                                            $r_level_name         = $row["level_name"];
                                            $r_office_name        = $row["office_name"];

                                            echo "<tr>",
                                                 "<td class='text-center'>".(++$order)."</td>",
                                                 "<td>$r_first_name $r_last_name</td>",
                                                 "<td>$r_position_name</td>",
                                                 "<td>$r_level_name</td>",
                                                 "<td>$r_office_name</td>",
                                                 "<td>$r_register_date</td>",
                                                 "<td>
                                                 <form action='admin_approve_rsvfrm.php' method='post'>
                                                    <input type='hidden' name='rsvform_id' value='$r_reserve_form_id'>
                                                    <button class='btn btn-warning btn-sm'><i class='fa fa-search' aria-hidden='true'></i> ตรวจสอบ</button>
                                                 </form>
                                                 </td>",
                                                 "</tr>";
                                        }
                                    }else{
                                        echo "<tr><td class='text-center' colspan='7'>- ไม่มีรายการคำร้องขอฯ -</td></tr>";
                                    }
                                    
                                    ?>
                                </tbody>
                            </table>


                        <?php
                        }
                    }

                ?>

            </div>
        </div>

    </div>
</div>
<!-- Content -->

<?php include_once "include/footer.php"; ?>
<?php include_once "include/footer_end.php"; ?>
