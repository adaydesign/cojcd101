<?php
    $building = filter_input(INPUT_POST,"building",FILTER_SANITIZE_SPECIAL_CHARS);
    $level = filter_input(INPUT_POST,"level",FILTER_SANITIZE_SPECIAL_CHARS);

    if(!empty($building) && !empty($level)){
        include_once "../model/building.class.php";
        include_once "../model/level_group.class.php";
        include_once "../model/buildings.new.php";

        include_once "../include/db_connection.config.php";
        include_once "../model/database.class.php";
        include_once "../include/util_functions.php";

        // get level id
        $group      = $buildings[ $building-1 ]->groups;
        $level_nums = $group[ $level-1 ]->levels;
        $level_cond = array();
        foreach($level_nums AS $l){
            $level_cond[] = "tb_users.level_id=$l";
        }
        $level_cond_text = implode(" OR ",$level_cond);

        $db = new Database();
        if($db->isConnected()){
            $sql = "SELECT tb_users.first_name,tb_users.last_name,
                           tb_position.position_name,tb_level.level_name,
                           tb_reserve_form.register_date,
                           tb_bkk_courts.name AS office_name
                    FROM tb_building_select
                    INNER JOIN tb_reserve_form ON tb_reserve_form.id=tb_building_select.reserve_form_id
                    INNER JOIN tb_users ON tb_users.id = tb_reserve_form.user_id
                    INNER JOIN tb_position ON tb_position.id = tb_users.position_id
                    INNER JOIN tb_level ON tb_level.id = tb_users.level_id
                    INNER JOIN tb_bkk_courts ON tb_bkk_courts.id = tb_users.office_id
                    WHERE tb_building_select.building_id=:building_id AND 
                    ($level_cond_text) AND
                    (tb_reserve_form.form_status=4 OR tb_reserve_form.form_status=2)";
        
            $db->query($sql);
            $db->bind(":building_id",$building);

            if($db->execute()){

                echo "<table class='table table-striped table-sm'>",
                "<thead>",
                    "<tr>",
                        "<th>ลำดับ</th>",
                        "<th>ชื่อ-นามสกุล</th>",
                        "<th>ตำแหน่ง</th>",
                        "<th>สังกัด</th>",
                        "<th>วันเวลา ที่ยื่นคำร้อง</th>",
                    "</tr>",
                "</thead>",
                "<tbody>";

                if($db->rowCount() > 0){
                    $result = $db->resultSet();
                    $order = 1;
                    foreach($result AS $row){
                        $user_full_name = $row["first_name"]." ".$row["last_name"];
                        $position_name  = $row["position_name"].$row["level_name"];
                        $office_name    = $row["office_name"];
                        $register_date  = getDateThai($row["register_date"]);

                        echo "<tr>",
                        "<td class='text-center'>".($order++)."</td>",
                        "<td>$user_full_name</td>",
                        "<td>$position_name</td>",
                        "<td>$office_name </td>",
                        "<td>$register_date</td>",
                        "</tr>";
                    }
                }else{

                }

                echo "</tbody>",
                "</table>";

            }
            
        }

        $db->close();
    }

?>