<?php
    $pos_id = filter_input(INPUT_POST,"position_id",FILTER_SANITIZE_SPECIAL_CHARS);
    $lv_id  = filter_input(INPUT_POST,"level_id",FILTER_SANITIZE_SPECIAL_CHARS);
    
    if(!empty($pos_id)){
        include_once "../include/config.php";
        include_once "../model/database.class.php";

        $db = new Database();
        $sql = "SELECT tb_position.id AS position_id,
                tb_level.id AS level_id, 
                tb_level.level_name AS level_name
            FROM tb_position_level 
            INNER JOIN tb_position ON tb_position.id = tb_position_level.position_id 
            INNER JOIN tb_level ON tb_level.id = tb_position_level.level_id
            WHERE position_id=:pos_id";

        $db->query($sql);
        $db->bind(":pos_id",$pos_id);
        if($db->execute()){
            /*<select class="custom-select form-control" id="position_input">
            <option value="0" selected>- เลือกระดับ -</option>
            </select>*/
            $line = "";
            $line .= "<select class='custom-select form-control' id='level_input' name='level_input'>";
            $result = $db->resultSet();
            foreach($result AS $v){
                $level_id   = $v['level_id'];
                $level_name = $v['level_name'];

                $select = $level_id==$lv_id?" selected":"";
                $line .= "<option value='$level_id' $select>$level_name</option>";
            }
            $line .= "</select>";
            
            echo $line;
        }

        $db->close();

    }else{
        echo "- กรุณาเลือกตำแหน่ง -";
    }
?>