<?php
    // Menu and Sub menu
    define("PAGE_MENU_INDEX",2);
    define("PAGE_SUBMENU_INDEX",0);

    // Breadcrumb Setting
    // array("title"=>"link")
    $PAGE_BREAD_CRUMB = array();
?>

<?php include_once "include/header.php"; ?>
<?php include_once "include/header_end.php"; ?>

<?php
    include_once "model/building.class.php";
    include_once "model/level_group.class.php";
    include_once "model/buildings.new.php";
?>


<div class="row mt-4">
    <div class="col text-center">
        <h2 class="text-info">รายชื่อผู้รอจัดสรรเข้าพักอาศัยอาคารที่พักศาลยุติธรรม (เขตกรุงเทพมหานคร)</h2>
        <div class="w-100"></div>

        <div class="form-group row mt-5">
            <label for="position_input" class="col-lg-3 col-form-label text-center" >สถานที่</label>
            <div class="col-lg-6">
                <select class="custom-select form-control" id="sel_building" name="sel_building">
                <?php
                    $val = 1;
                    foreach($buildings AS $build){
                        echo "<option value='".($val++)."'>".$build->title."</option>";
                    }    
                ?>
                </select>
            </div>
        </div>

        <div class="form-group row mt-3">
            <label for="position_input" class="col-lg-3 col-form-label text-center" >กลุ่ม</label>
            <div class="col-lg-6" id="div_level">
                <select class="custom-select form-control" id="sel_level" name="sel_level">
                <?php
                    $val = 1;
                    foreach($buildings[0]->groups AS $group){
                        echo "<option value='".($val++)."'>".$group->levelName."</option>";
                    }    
                ?>
                </select>
            </div>
        </div>
        <div class="w-100"></div>           
        <hr class="border-info">
    </div>
</div>

<!-- Result Search -->
<div class="row">
    <div class="col" id="div_result_search">
    </div>
</div>

<?php include_once "include/footer.php"; ?>

<script>

    $(function(){
        
        // initial search
        search(1,1);

        $("#sel_building").change(function(){
            // render level ...
            url_link1 = "render/build_level.render.php";
            values    = {val:$(this).val()};
            $.ajax({
              url : url_link1,
              type: "POST",
              data: values,
              success: function(response){
                $("#sel_level").html(response);
              },
              error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
              }
          });

            // search
            var build_val = $(this).val();
            var level_val = 1;
            search(build_val,level_val);
        });

        $("#sel_level").change(function(){
            // search
            var build_val = $("#sel_building").val();
            var level_val = $(this).val();
            search(build_val,level_val);
        });

        function search(building,level){
            //console.log(building+" - "+level)

            // render level ...
            url_link1 = "render/rs_search_reqts.render.php";
            values    = {building:building,level:level};
            $.ajax({
              url : url_link1,
              type: "POST",
              data: values,
              success: function(response){
                // console.log(response);
                $("#div_result_search").html(response);
              },
              error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
              }
          });
        }

    });
</script>

<?php include_once "include/footer_end.php"; ?>
