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
            $sql     = "SELECT * FROM tb_users WHERE id=:id";
            $db->query($sql);
            $db->bind(":id",$user_id);
            $db->execute();
            
            if($db->rowCount() > 0){
                $rs_row         = $db->singleResult();
                $USER_ID        = $rs_row["id"];
                $USER_NAME      = $rs_row["username"];
                $USER_FULL_NAME = trim($rs_row["first_name"]." ".$rs_row["last_name"]);
                $USER_GROUP     = $rs_row["user_group"];
                $USER_STATE     = $rs_row["user_state"];

                $USER_LOGIN     = true;
            }
        }

        $db->close();

    }else{
        // ...
    }
?>