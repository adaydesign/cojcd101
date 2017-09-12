<?php

$file     = filter_input(INPUT_GET,"file",FILTER_SANITIZE_SPECIAL_CHARS);
$filename = "CCMS_file.pdf";

if(!empty($file)){
    //echo base64_decode($file);
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="'.$filename.'"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    @readfile( base64_decode($file) );
}


?>