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

for($i=0;$i<100;$i++){
    $id_card = "112232388769"+$i;
    $email   = "demo$i@mail.com";
    $username = "demo$i";
    $password = md5("demo90875"+$i);
    $result = $conn->query("INSERT INTO tb_users (id_card,email,username,password,register_date) 
    VALUES ('$id_card','$email','$username','$password',NOW())");
    echo $conn->insert_id." >> ";
    echo $result ? "เพิ่มข้อมูลได้สำเร็จ":"ไม่สามารถเพิ่มข้อมูลได้";
    echo "<hr>";

    if(!$result){
        break;
    }
}



?>