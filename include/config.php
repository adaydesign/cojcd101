<?php

//-------------------- System Version ------------------------------
define("SYS_NAME","ระบบบริหารจัดการห้องพักศาลยุติธรรม");
define("SYS_NAME_2","COJ CONDO");
define("SYS_VERSION","0.5.3");

//-------------------- Database connection -------------------------
define("DB_LOCAL_TEST",false);
define("DB_OFFLINE_URL","mysql://cojcd_admin:nffuF5S5Y9GUP5yw@localhost/heroku_733e7485a90f5eb");
define("DB_ONLINE_URL","CLEARDB_DATABASE_URL");
//define("DB_ONLINE_URL","mysql://bf60e5c13b1643:ffdf89ba@us-cdbr-iron-east-05.cleardb.net/heroku_733e7485a90f5eb");

$url_var = DB_OFFLINE_URL;
if(!DB_LOCAL_TEST){
    $url_var = getenv(DB_ONLINE_URL);
    //$url_var = DB_ONLINE_URL;
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

//-------------------- PAGE TOP MENU CONSTANT ------------------------------------
define("TOPMENU_INDEX_HOME",0);
define("TOPMENU_INDEX_HELP",1);
define("TOPMENU_INDEX_RESERVATION",2);
define("TOPMENU_INDEX_MEMBER",3);
define("TOPMENU_INDEX_ADMIN",4);
define("TOPMENU_INDEX_USER_LOGIN",5);

?>