<?php 
    if(!isset($_SESSION)) { 
        session_start(); 
    }  
?>
<?php
    $l_username = filter_input(INPUT_POST,"login_username",FILTER_SANITIZE_SPECIAL_CHARS);
    $l_password = filter_input(INPUT_POST,"login_password",FILTER_SANITIZE_SPECIAL_CHARS);

    $result     = array("form"=>"login","result"=>false,"message"=>"พบข้อผิดพลาด");

    if(!empty($l_username) && !empty($l_password)){
        include_once "../include/config.php";
        include_once "../model/database.class.php";

        $db = new Database();
        if($db->isConnected()){
            $sql    = "SELECT * FROM tb_users WHERE username=:username AND password=:password";
            $sql_v  = array(":username"=>$l_username,":password"=>md5($l_password));
            $db->query($sql);
            $db->bindValues($sql_v);
            $db->execute();

            if($db->rowCount() > 0){
                $result["result"] = true;
                $result["message"]= "ยินดีต้อนรับ $l_username เข้าสู่ระบบ";

                // KEEP IN SESSION Key and Value
                $rs_rows = $db->resultset();
                $rs0     = $rs_rows[0];
                $_SESSION['user_id']    = $rs0['id'];
                $_SESSION['username']   = $rs0['username'];

            }else{
                $result["result"] = false;
                $result["message"]= "ชื่อผู้ใช้ หรือรหัสผ่าน ไม่ถูกต้อง";
            }
        }

        $db->close();
    }

    echo json_encode($result);
?>