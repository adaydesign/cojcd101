<?php
echo "^^|| hello COJ CD 101 :)";
echo "<hr>";

/*
// true = local host, false = deploy on server
*/
$debug = true; 

//$CLEARDB_DATABASE_URL = "mysql://bf60e5c13b1643:ffdf89ba@us-cdbr-iron-east-05.cleardb.net/heroku_733e7485a90f5eb?reconnect=true";
//$url = parse_url(getenv($CLEARDB_DATABASE_URL));
$url_var = "mysql://lbkcadmin:Lbkc@db#2016@localhost/heroku_733e7485a90f5eb";
if(!$debug){
    //$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $url_var = getenv("CLEARDB_DATABASE_URL");
}

$url = parse_url($url_var);
//print_r($url);
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

if($conn->get_connection_stats()){
    echo "connected to database.";
}else{
    echo "database connection fail";
    exit;
}
echo "<hr>";

for($i=0;$i<100;$i++){
    $id_card = "10901299088769"+$i;
    $email   = "demo$i@mail.com";
    $username = "demo$i";
    $password = md5("demo0075"+$i);
    $result = $conn->query("INSERT INTO tb_users (id_card,email,username,password,register_date) 
    VALUES ('$id_card','$email','$username','$password',NOW())");
    echo $conn->insert_id." >> ";
    echo $result ? "เพิ่มข้อมูลได้สำเร็จ":"ไม่สามารถเพิ่มข้อมูลได้";
    echo "<hr>";

    if(!$result){
        break;
    }

}

$sql0 = "SELECT * FROM tb_users";
$result2 = $conn->query($sql0);

if($result2->num_rows > 0){
    echo "<table>";
    while($rs_row = $result2->fetch_assoc()){
        $r_username = $rs_row['username'];
        $r_id       = $rs_row['id'];
        $r_email    = $rs_row['email'];
        echo "<tr>";
        echo "<td>$r_id</td>";
        echo "<td>$r_username</td>";
        echo "<td>$r_email</td>";
        echo "</tr>";
    }
    echo "</table>";
}



?>