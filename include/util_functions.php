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
?>