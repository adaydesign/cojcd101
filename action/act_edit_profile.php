<?php
    //print_r($_POST);
    $first_name_input   = filter_input(INPUT_POST,"first_name_input",FILTER_SANITIZE_SPECIAL_CHARS);
    $last_name_input    = filter_input(INPUT_POST,"last_name_input",FILTER_SANITIZE_SPECIAL_CHARS);
    $id_card_input      = filter_input(INPUT_POST,"id_card_input",FILTER_SANITIZE_SPECIAL_CHARS);
    $tel_input          = filter_input(INPUT_POST,"tel_input",FILTER_SANITIZE_SPECIAL_CHARS);
    $position_input     = filter_input(INPUT_POST,"position_input",FILTER_SANITIZE_SPECIAL_CHARS);
    $level_input        = filter_input(INPUT_POST,"level_input",FILTER_SANITIZE_SPECIAL_CHARS);
    $user_id            = filter_input(INPUT_POST,"user_id",FILTER_SANITIZE_SPECIAL_CHARS);
    $office_input       = filter_input(INPUT_POST,"office_input",FILTER_SANITIZE_SPECIAL_CHARS);
    
    $result     = array("form"=>"edit_profile","result"=>false,"message"=>"พบข้อผิดพลาด");

    if(!empty($position_input) && !empty($level_input) && !empty($office_input)){
        // update
        include_once "../include/db_connection.config.php";
        include_once "../model/database.class.php";

        $db = new Database();
        if($db->isConnected()){
            $sql = "UPDATE tb_users SET first_name=:first_name,
                        last_name=:last_name,id_card=:id_card,tel=:tel,
                        position_id=:position_id,level_id=:level_id,office_id=:office_id
                    WHERE id=:id";
            $db->query($sql);
            $sql_v = array( ":first_name"   => $first_name_input,
                        ":last_name"    => $last_name_input,
                        ":id_card"      => $id_card_input,
                        ":tel"          => $tel_input,
                        ":position_id"  => $position_input,
                        ":level_id"     => $level_input,
                        ":id"           => base64_decode($user_id),
                        ":office_id"    => $office_input);
            $db->bindValues($sql_v);

            if($db->execute()){
                $result["result"]   = true;
                $result["message"]  = "ปรับปรุงข้อมูลเรียบร้อย";
            }else{
                $result["result"]   = false;
                $result["message"]  = "พบข้อผิดพลาดในการปรับปรุงข้อมูล";
            }
        }else{
            $result["result"]   = false;
            $result["message"]  = "ไม่สามารถติดต่อฐานข้อมูลได้";
        }

        $db->close();

    }else{
        if(empty($position_input) || empty($level_input)){
            $result["message"]  = "กรุณาเลือกตำแหน่ง และ ระดับ";
        }else if(empty($office_input)){
            $result["message"]  = "กรุณาเลือกสังกัด";
        }
    }

    echo json_encode($result);
?>