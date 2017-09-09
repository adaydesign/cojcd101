<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }  

    $USER_LOGIN = false;
    if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){

        include_once "model/database.class.php";

        $user_id = $_SESSION['user_id'];
        $db      = new Database();
        if($db->isConnected()){
            $sql     = "SELECT  tb_users.id AS user_id,
                                tb_users.username,tb_users.first_name,tb_users.last_name,
                                tb_users.user_group,tb_users.user_state,
                                tb_user_state_label.label_name
                        FROM tb_users 
                        INNER JOIN tb_user_state_label ON tb_user_state_label.id=tb_users.user_state
                        WHERE tb_users.id=:id";
            $db->query($sql);
            $db->bind(":id",$user_id);
            $db->execute();
            
            if($db->rowCount() > 0){
                $rs_row             = $db->singleResult();
                $USER_ID            = $rs_row["user_id"];
                $USER_NAME          = $rs_row["username"];
                $USER_FULL_NAME     = trim($rs_row["first_name"]." ".$rs_row["last_name"]);
                $USER_GROUP         = $rs_row["user_group"];
                $USER_STATE         = $rs_row["user_state"];
                $USER_STATE_LABEL   = $rs_row["label_name"];

                // display name
                $USER_DISPLAY_NAME  = !empty($USER_FULL_NAME)?$USER_FULL_NAME:$USER_NAME;

                $USER_LOGIN         = true;
            }
        }

        $db->close();

    }else{
        // ...
    }
?>