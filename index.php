<?php 
//mysql://bf60e5c13b1643:ffdf89ba@us-cdbr-iron-east-05.cleardb.net/heroku_733e7485a90f5eb?reconnect=trues
echo "hello COJ CD 101";

$url = parse_url(getenv("us-cdbr-iron-east-05.cleardb.net"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);
$result = $conn->query("SELECT * FROM tb_users");
echo $result->num_rows;

?>