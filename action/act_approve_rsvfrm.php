<?php

    $a_data       = filter_input(INPUT_POST,"approve_data",FILTER_SANITIZE_SPECIAL_CHARS);
    $a_doc        = filter_input(INPUT_POST,"approve_doc",FILTER_SANITIZE_SPECIAL_CHARS);
    $rsv_frm_id   = filter_input(INPUT_POST,"rsv_frm_id",FILTER_SANITIZE_SPECIAL_CHARS);
    $approver_id   = filter_input(INPUT_POST,"approver_id",FILTER_SANITIZE_SPECIAL_CHARS);
    
    $result       = array("form"=>"approve_rsvfrm","result"=>false,"message"=>"พบข้อผิดพลาด");

    if(!empty($rsv_frm_id) && !empty($approver_id)){
        if($a_data > 0 && $a_doc > 0){
            
            // update table ..
            include_once "../include/db_connection.config.php";
            include_once "../model/database.class.php";

            $db = new Database();
            if($db->isConnected()){
                $sql = "UPDATE tb_reserve_form SET
                form_status=:form_status,approver_id=:approver_id,
                approve_date=NOW(),approver_note=:approver_note
                WHERE id=:id";

                $new_form_status    = $a_data==1&&$a_doc==1?6:7; // 6 = completed, 7 = incomplete
                $new_approver_note   = $a_data==1?"ข้อมูลคำร้องสมบูรณ์":"ข้อมูลคำร้องไม่สมบูรณ์";
                $new_approver_note  .= $a_doc==1?" เอกสารประกอบสมบูรณ์":" เอกสารประกอบไม่สมบูรณ์";

                $db->query($sql);
                $sql_v = array( ":id"           => base64_decode($rsv_frm_id),
                                ":form_status"  => $new_form_status,
                                ":approver_id"  => base64_decode($approver_id),
                                ":approver_note" => $new_approver_note);
                $db->bindValues($sql_v);

                if($db->execute()){
                    $result["result"]  = true;
                    $result["message"] = "ผู้ดูแลระบบตรวจสอบคำร้องและเอกสารเรียบร้อย";
                }else{
                    $result["result"]  = false;
                    $result["message"] = "ไม่สามารถอัพเดทสถานะของการตรวจสอบคำร้องได้";
                }
            }
            $db->close();

        }else{
            $result["result"]  = false;
            $result["message"] = "กรุณาเลือกการอนุมัติ ข้อมูลคำร้องและเอกสารประกอบ";
        }
    }
   
    echo json_encode($result);

?>