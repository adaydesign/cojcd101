<?php




    /*
     function : selectedTopMenu
     param  $menu_index is index of top menu (fix)
            $page_menu_index is index of page menu (current page)
    */
    function selectedTopMenu($menu_index,$page_menu_index){
        if($menu_index==$page_menu_index){
            echo "active";
        }
    }

    /* function: getDateThai
	 * Example	
	 *
	 * $strDate = "2008-08-14 13:42:44";
	 * $date_only, 		default false 	set this is true, when want to show only date text. 
	 * $spr, 			default ', '    set this is sparate text as you want, it's between date and time text.
	 * $form, 			default 0   	set this is true, when want to show full date text format in thai. (see thai date format .. (top))
     *
     * $form -> 0 1 2
	 * echo getDateThai($strDate);
	 */
	function getDateThai($strDate,$date_only=false,$spr=', ',$form=0){
		date_default_timezone_set('Asia/Bangkok'); //set default time zone to Asia/Bangkok
		if($strDate != NULL && $strDate!='0000-00-00'){
			$strYear 	= date("Y",strtotime($strDate))+543; //พ.ศ.
			$strMonth 	= date("n",strtotime($strDate));
			$strDay 	= date("j",strtotime($strDate));
			$strHour 	= date("H",strtotime($strDate));
			$strMinute 	= date("i",strtotime($strDate));
			$strSeconds = date("s",strtotime($strDate));
			$strDoW 	= date("N",strtotime($strDate));// day of week

			$strDowCut = Array("","จ.","อ.","พ.","พฤ","ศ.","ส.","อา");
			$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			if($form==1 || $form==2){
				$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			}
			$strMonthThai=$strMonthCut[$strMonth];

			if($date_only && ($form==0 || $form==2) ){
				return "$strDay $strMonthThai $strYear";
			}
			else if($date_only==false && $form==0){
				return "$strDay $strMonthThai $strYear".$spr."เวลา $strHour:$strMinute น.";
			}

		}else{
			return "";
		}
	}


?>