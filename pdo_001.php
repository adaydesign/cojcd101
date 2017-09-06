<?php

include_once "model/database.class.php";

//mysql://cojcd_admin:nffuF5S5Y9GUP5yw@localhost/heroku_733e7485a90f5eb
define("DB_HOST","localhost");
define("DB_USER","cojcd_admin");
define("DB_PASS","nffuF5S5Y9GUP5yw");
define("DB_NAME","heroku_733e7485a90f5eb");

$db = new Database();

$sql = "INSERT INTO tb_users (username,password,id_card,email,register_date) VALUES
(:username, :password, :id_card, :email, :register_date)";

$db->query($sql);
/*$db->bind(":username","user001");
$db->bind(":password",md5("77diekjd"));
$db->bind(":id_card","1222388890000");
$db->bind(":email","user0001@mail");
$db->bind(":register_date","now()");*/

$db->execute();

echo $db->lastInsertId();

$db->close();
?>