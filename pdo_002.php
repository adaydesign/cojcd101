<?php

include_once "include/config.php";
include_once "model/database.class.php";

$db = new Database();
echo $db->isConnected() ? "db connected":"db connection, fail";

if($db->isConnected()){
    $sql = "INSERT INTO tb_users (username,password,id_card,email,register_date) 
    VALUES (:username,:password,:id_card,:email,NOW())";

    $values = array(":username" => "user002",
                    ":password" => md5("sko2w2K!Ks#$"),
                    ":id_card"  => "2344763880009",
                    ":email"    => "m0_mail@mail.com"); 

    $db->query($sql);
    $db->bindValues($values);
    $db->execute();

    echo $db->lastInsertId();
}
$db->close();


?>