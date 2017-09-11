<?php

   $user_marriage_status        = trim(filter_input(INPUT_POST,"user_marriage_status",FILTER_SANITIZE_SPECIAL_CHARS));
   $sp_first_name_input         = trim(filter_input(INPUT_POST,"sp_first_name_input",FILTER_SANITIZE_SPECIAL_CHARS));
   $sp_last_name_input          = trim(filter_input(INPUT_POST,"sp_last_name_input",FILTER_SANITIZE_SPECIAL_CHARS));
   $spouse_position_label       = trim(filter_input(INPUT_POST,"spouse_position_label",FILTER_SANITIZE_SPECIAL_CHARS));
   $spouse_office_label         = trim(filter_input(INPUT_POST,"spouse_office_label",FILTER_SANITIZE_SPECIAL_CHARS));
   $address                     = trim(filter_input(INPUT_POST,"address",FILTER_SANITIZE_SPECIAL_CHARS));
   $house_owner_status          = trim(filter_input(INPUT_POST,"house_owner_status",FILTER_SANITIZE_SPECIAL_CHARS));
   $house_owner_is_label        = trim(filter_input(INPUT_POST,"house_owner_is_label",FILTER_SANITIZE_SPECIAL_CHARS));
   $select_building_1           = trim(filter_input(INPUT_POST,"select_building_1",FILTER_SANITIZE_SPECIAL_CHARS));
   $select_building_2           = trim(filter_input(INPUT_POST,"select_building_2",FILTER_SANITIZE_SPECIAL_CHARS));
   $select_building_3           = trim(filter_input(INPUT_POST,"select_building_3",FILTER_SANITIZE_SPECIAL_CHARS));
   $doc_1_path                  = trim(filter_input(INPUT_POST,"doc_1_path",FILTER_SANITIZE_SPECIAL_CHARS));
   $doc_2_path                  = trim(filter_input(INPUT_POST,"doc_2_path",FILTER_SANITIZE_SPECIAL_CHARS));
   $doc_3_path                  = trim(filter_input(INPUT_POST,"doc_3_path",FILTER_SANITIZE_SPECIAL_CHARS));
   $doc_4_path                  = trim(filter_input(INPUT_POST,"doc_4_path",FILTER_SANITIZE_SPECIAL_CHARS));
   $doc_5_path                  = trim(filter_input(INPUT_POST,"doc_5_path",FILTER_SANITIZE_SPECIAL_CHARS));
   $num_child_label             = trim(filter_input(INPUT_POST,"num_child_label",FILTER_SANITIZE_SPECIAL_CHARS));
   $other_house_owner_is_label  = trim(filter_input(INPUT_POST,"other_house_owner_is_label",FILTER_SANITIZE_SPECIAL_CHARS));
   $user_id                     = trim(filter_input(INPUT_POST,"user_id",FILTER_SANITIZE_SPECIAL_CHARS));

   $result     = array("form"=>"send_rsv_form","result"=>false,"message"=>"พบข้อผิดพลาด");

   //check empty
   $sp_first_name_input     = empty($sp_first_name_input)?"":$sp_first_name_input;
   $sp_last_name_input      = empty($sp_last_name_input)?"":$sp_last_name_input;
   $spouse_position_label   = empty($spouse_position_label)?"":$spouse_position_label;
   $spouse_office_label     = empty($spouse_office_label)?"":$spouse_office_label;
   $doc_1_path              = empty($doc_1_path)?"":$doc_1_path;
   $doc_2_path              = empty($doc_2_path)?"":$doc_2_path;
   $doc_3_path              = empty($doc_3_path)?"":$doc_3_path;
   $doc_4_path              = empty($doc_4_path)?"":$doc_4_path;
   $doc_5_path              = empty($doc_5_path)?"":$doc_5_path;

   if($house_owner_is_label==-2){
    $house_owner_is_label = $other_house_owner_is_label;
   }

   if(isset($user_marriage_status) && $user_marriage_status >= 0){
        include_once "../include/db_connection.config.php";
        include_once "../model/database.class.php";

        $db = new Database();
        // insert into tb_reserve_form
        $sql = "INSERT INTO tb_reserve_form (marry_status,spouse_first_name,spouse_last_name,spouse_position,
        spouse_office,num_child,address,house_status,house_owner,path_copy_officer_card,
        path_copy_census,path_copy_marriage_license,path_copy_changed_name,path_copy_current_census,register_date,user_id,form_status) 
        VALUES(:marry_status,:spouse_first_name,:spouse_last_name,:spouse_position,
        :spouse_office,:num_child,:address,:house_status,
        :house_owner,:path_copy_officer_card,:path_copy_census,:path_copy_marriage_license,
        :path_copy_changed_name,:path_copy_current_census,NOW(),:user_id,1)";

        $db->query($sql);
        $sql_v = array( ":marry_status"          =>$user_marriage_status,
                        ":spouse_first_name"     =>$sp_first_name_input,
                        ":spouse_last_name"      =>$sp_last_name_input,
                        ":spouse_position"       =>$spouse_position_label,
                        ":spouse_office"         =>$spouse_office_label,
                        ":num_child"             =>$num_child_label,
                        ":address"               =>$address,
                        ":house_status"          =>$house_owner_status,
                        ":house_owner"           =>$house_owner_is_label,
                        ":path_copy_officer_card"=>$doc_1_path ,
                        ":path_copy_census"      =>$doc_2_path ,
                        ":path_copy_marriage_license"   =>$doc_3_path ,
                        ":path_copy_changed_name"       =>$doc_4_path ,
                        ":path_copy_current_census"     =>$doc_5_path ,
                        ":user_id"               => base64_decode($user_id)); 

        $db->bindValues($sql_v);
        if($db->execute()){
            $rsv_form_id = $db->lastInsertId();
            // insert into tb_building_select
            if(!empty($select_building_1) || !empty($select_building_2) || !empty($select_building_3)){
                $db2 = new Database();
                if($db2->isConnected()){

                    $sql2 = "INSERT INTO tb_building_select
                    (reserve_form_id,building_id) VALUES
                    (:reserve_form_id,:building_id)";

                    $db2->beginTransaction();
                    $db2->query($sql2);
                    $success = false;

                    if(!empty($select_building_1)){
                        $sql2_v = array(":reserve_form_id"  =>$rsv_form_id,
                                        ":building_id"      =>1);
                        $db2->bindValues($sql2_v);
                        $success = $db2->execute();
                    }
                    if(!empty($select_building_2)){
                        $sql2_v = array(":reserve_form_id"  =>$rsv_form_id,
                                        ":building_id"      =>2);
                        $db2->bindValues($sql2_v);
                        $success = $db2->execute();
                    }
                    if(!empty($select_building_3)){
                        $sql2_v = array(":reserve_form_id"  =>$rsv_form_id,
                                        ":building_id"      =>3);
                        $db2->bindValues($sql2_v);
                        $success = $db2->execute();
                    }

                    $db2->endTransaction();

                    // final
                    $result["result"]   = $success;
                    $result["message"]  = $success?"เพิ่มข้อมูลการส่งคำขอสำเร็จ":"ส่งคำขอไม่สำเร็จ : ขั้นตอนการเพิ่มอาคารที่เลือก";
                }

                $db2->close();
            }

        }else{
            $result["result"]   = false;
            $result["message"]  = "ส่งคำขอไม่สำเร็จ : ขั้นตอนการเพิ่มคำขอใหม่";
        }

        $db->close();
   }

   echo json_encode($result);
?>