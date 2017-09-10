<?php

$position = array(1,1,2,2,3,3,3,3,4,4,4,5,5,5,6,6,6,7,7,7,8,8,8,9,9,9,10,10,10,11,11,11,12,12,12,12,
13,13,13,14,14,14,15,15,15,16,16,16,17,17,17,18,18,18,19,19,20,20,20,21,21,22,22,22,23,23,24,24);
$level    = array(1,2,1,2,3,4,5,6,4,5,6,4,5,6,4,5,6,4,5,6,4,5,6,4,5,6,4,5,6,4,5,6,3,4,5,6,4,5,6,4,5,6,4,5,6,4,5,6,
4,5,6,4,5,6,8,9,7,8,9,8,9,7,8,9,8,9,8,9);

/*
// Check
if(count($position)==count($level)){
    for($i=0;$i<count($position); $i++){
        echo $position[$i]."-".$level[$i]."<br>";
    }
}*/


include "include/config.php";
include "model/database.class.php";

$db = new Database();

    if($db->isConnected()){


        $sql = "INSERT INTO tb_position_level (position_id,level_id) 
        VALUE (:position_id,:level_id)";
        
        echo "--- Start Insert ----<br>";
        $db->beginTransaction();

        for($i=0;$i<count($position); $i++){
            //echo $position[$i]."-".$level[$i]."<br>";
            $pos_id     = $position[$i];
            $level_id   = $level[$i];
            $db->query($sql);
            $db->bind(":position_id",$pos_id);
            $db->bind(":level_id",$level_id);
            if($db->execute()===true){
                echo "-> insert OK: ($pos_id -$level_id)<br>";
            }
        }

        $db->endTransaction();

        $db->close();
        echo "--- End all execute ---<br>";


    }
    
?>