<?php 
//mysql://bf60e5c13b1643:ffdf89ba@us-cdbr-iron-east-05.cleardb.net/heroku_733e7485a90f5eb?reconnect=trues
echo "hello COJ CD 101";
$CLEARDB_DATABASE_URL = "mysql://bf60e5c13b1643:ffdf89ba@us-cdbr-iron-east-05.cleardb.net/heroku_733e7485a90f5eb?reconnect=true";
$url = parse_url(getenv($CLEARDB_DATABASE_URL));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);
print_r($url);
$conn = new mysqli($server, $username, $password, $db);
$result = $conn->query("SELECT * FROM tb_users");
echo $result->num_rows;

?>