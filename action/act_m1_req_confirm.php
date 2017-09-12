<?php
    $r_doc_req_id   = filter_input(INPUT_POST,"doc_req_id",FILTER_SANITIZE_SPECIAL_CHARS);
    $r_doc_confirm  = filter_input(INPUT_POST,"doc_confirm",FILTER_SANITIZE_SPECIAL_CHARS);

    $result         = array("form"=>"confirm_req_doc", "result"=>false, "message"=>"พบข้อผิดพลาด");

    if(!empty($r_doc_req_id ) && !empty($r_doc_confirm)){
        //..
        include_once "../include/db_connection.config.php";
        include_once "../model/database.class.php";

        $db = new Database();
        if($db->isConnected()){
            $r_doc_req_id     = base64_decode($r_doc_req_id);
            $r_doc_new_status = $r_doc_confirm=="true"?"2":"3";
            $title            = "";
            if($r_doc_confirm=="true"){
                $title  = "การยืนยัน";
            }else{
                $title  = "การยกเลิก";
            }

            $sql    = "UPDATE tb_reserve_form SET form_status=:form_status
                        WHERE id=:id";
            $db->query($sql);
            
            $sql_v  = array(":form_status"  => $r_doc_new_status,
                            ":id"           => $r_doc_req_id);
            $db->bindValues($sql_v);
            
            if($db->execute()){
                $result["result"]  = true;
                $result["message"] = "$title คำร้องเลขที่ $r_doc_req_id สำเร็จ";
            }else{
                $result["message"] = "$title คำร้องเลขที่ $r_doc_req_id ไม่สำเร็จ";
            }
        }

        $db->close();
    }

    echo json_encode($result);
?>