<?php
    $val = filter_input(INPUT_POST,"val",FILTER_SANITIZE_SPECIAL_CHARS);
    if(!empty($val)){
        include_once "../model/building.class.php";
        include_once "../model/level_group.class.php";
        include_once "../model/buildings.new.php";

        $echo = "<select class='custom-select form-control' id='sel_level' name='sel_level'>";
        $index = 1;
        foreach($buildings[$val-1]->groups AS $group){
            $echo .= "<option value='".($index++)."'>".$group->levelName."</option>";
        } 
        $echo .="</select>";

        echo $echo;
    }
?>
