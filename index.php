<?php 
//mysql://bf60e5c13b1643:ffdf89ba@us-cdbr-iron-east-05.cleardb.net/heroku_733e7485a90f5eb?reconnect=trues
echo "|| hello COJ CD 101 :)";
//$CLEARDB_DATABASE_URL = "mysql://bf60e5c13b1643:ffdf89ba@us-cdbr-iron-east-05.cleardb.net/heroku_733e7485a90f5eb?reconnect=true";
//$url = parse_url(getenv($CLEARDB_DATABASE_URL));

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
print_r($url);
$conn = new mysqli($server, $username, $password, $db);

$id_card = "112232388760";
$email   = "moois@mail.com";
$username = "moisoe";
$password = md5("dk90875$dh");
$register_date = "now()";
$result = $conn->query("INSERT INTO tb_users (id_card,email,username,password,register_date) 
VALUES ('$id_card','$email','$username','$password',$register_date)");
echo $conn->insert_id;
echo "<br>";
echo $result ? "เพิ่มข้อมูลได้สำเร็จ":"ไม่สามารถเพิ่มข้อมูลได้";



?>