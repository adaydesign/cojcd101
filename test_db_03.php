<?php

$level_name = array(
    "สูง"=>2,
    "ต้น"=>2,
    "เชี่ยวชาญ"=>1,
    "ชำนาญการพิเศษ"=>1,
    "ชำนาญการ"=>1,
    "ปฏิบัติการ"=>1,
    "อาวุโส"=>0,
    "ชำนาญงาน"=>0,
    "ปฏิบัติงาน"=>0
);

    
include "include/config.php";
include "model/database.class.php";

$db = new Database();

    if($db->isConnected()){


        $sql = "INSERT INTO tb_level (level_name,level_group) 
        VALUE (:level_name,:level_group)";
        
        echo "--- Start Insert ----<br>";
        $db->beginTransaction();
        foreach($level_name as $k=>$v){
            $db->query($sql);
            $db->bind(":level_name",$k);
            $db->bind(":level_group",$v);
            if($db->execute()===true){
                echo "-> insert OK: ($k-$v)<br>";
            }
        }

        $db->endTransaction();

        $db->close();
        echo "--- End all execute ---<br>";


    }


?>