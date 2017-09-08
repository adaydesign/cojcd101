<?php

//-------------------- System Version ------------------------------
define("SYS_NAME","ระบบบริหารจัดการอาคารที่พักศาลยุติธรรม");
define("SYS_VERSION","0.4.3");

//-------------------- Database connection -------------------------
define("DB_LOCAL_TEST",true);
define("DB_OFFLINE_URL","mysql://cojcd_admin:nffuF5S5Y9GUP5yw@localhost/heroku_733e7485a90f5eb");
//"mysql://bf60e5c13b1643:ffdf89ba@us-cdbr-iron-east-05.cleardb.net/heroku_733e7485a90f5eb"
define("DB_ONLINE_URL","CLEARDB_DATABASE_URL");

$url_var = DB_OFFLINE_URL;
if(!DB_LOCAL_TEST){
    $url_var = getenv(DB_ONLINE_URL);
}
$url        = parse_url($url_var);
$server     = $url["host"];
$username   = $url["user"];
$password   = $url["pass"];
$db_name    = substr($url["path"], 1);

define("DB_HOST",$server);
define("DB_USER",$username);
define("DB_PASS",$password);
define("DB_NAME",$db_name);

// echo DB_HOST." - ".DB_USER." - ".DB_PASS." - ".DB_NAME."<br>";


?>