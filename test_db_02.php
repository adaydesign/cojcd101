<?php

    // insert position data into tb_position
    include "include/config.php";
    include "model/database.class.php";


    $db = new Database();

    if($db->isConnected()){

        $position_names = array(
            "ผู้อำนวยการ",
            "ผู้อำนวยการเฉพาะด้าน",
            "เจ้าพนักงานศาลยุติธรรม",
            "เจ้าพนักงานคดี",
            "นักวิเทศสัมพันธ์",
            "นักวิชาการพัสดุ",
            "นักวิเคราะห์นโยบายและแผน",
            "บรรณารักษ์",
            "นักวิชาการเงินและบัญชี",
            "นักทรัพยากรบุคคล",
            "นักประชาสัมพันธ์",
            "นักวิชาการตรวจสอบสอบภายใน",
            "นักวิชาการคอมพิวเตอร์",
            "นิติกร",
            "สถาปนิก",
            "วิศวกรโยธา",
            "นักจัดการงานทั่วไป",
            "นักจิตวิทยา",
            "เจ้าหน้าที่ศาลยุติธรรม",
            "นายช่างศิลป์",
            "เจ้าพนักงานธุรการ",
            "นายช่างโยธา",
            "เจ้าพนักงานโสตทัศนศักษา",
            "เจ้าพนักงานการเงินและบัญชี"
        );


        $sql = "INSERT INTO tb_position (position_name) VALUE (:position_name)";
        
        echo "--- Start Insert ----";
        $db->beginTransaction();
        foreach($position_names as $v){
            $db->query($sql);
            $db->bind(":position_name",$v);
            if($db->execute()===true){
                echo "-> insert OK: ($v)";
            }
        }

        $db->endTransaction();

        $db->close();
        echo "--- End all execute ---";


    }
?>