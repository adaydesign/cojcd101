<?php
	if(!isset($_SESSION)) { 
        session_start(); 
	} 
	
	$result     = array("form"		=> "upload_pdf_rsv_file",
						"result"	=> false,
						"message"	=> "พบข้อผิดพลาด",
						"role"		=> 0,
						"file_path"	=> "");

    if(isset($_SESSION['user_id'])){
		$user_id = $_SESSION['user_id'];
		$role 	 = filter_input(INPUT_GET,"role",FILTER_SANITIZE_SPECIAL_CHARS);
		$dest 	 = filter_input(INPUT_GET,"dest",FILTER_SANITIZE_SPECIAL_CHARS).$user_id;
		if(!empty($role) && isset($_FILES)){
			//print_r($_FILES);
			if(!file_exists($dest) || !is_dir($dest)){
				if (!mkdir($dest, 0777, true)) {
					die('อัพโหลดไฟล์เอกสาร / Failed to create folders...');
				}
			}
			$date = new DateTime();
			$dest_file  = "rsvform_".md5($role."_".$user_id."_".$date->getTimestamp()).".pdf";
			$dest 	   .= "/".$dest_file;
			if(move_uploaded_file($_FILES["pdf_file"]["tmp_name"],$dest)){
				$result["result"] 	= true;
				$result["message"] 	= "อัพโหลดไฟล์ สำเร็จ";
				$result["role"] 	= $role;
				$result["file_path"]= substr($dest,3);
			}else{
				$result["result"] 	= false;
				$result["message"] 	= "อัพโหลดไฟล์ ไม่สำเร็จ";
				$result["role"] 	= $role;
			}
			
		}
	}
	
	echo json_encode($result);

?>