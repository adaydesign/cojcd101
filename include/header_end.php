    <!-- Bootstrap core CSS -->
    <link href="lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/sticky-footer-navbar.css" rel="stylesheet">
    <!-- Font -->
    <link href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="index.php"><?php echo SYS_NAME_2;?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item <?php selectedTopMenu(TOPMENU_INDEX_HOME,PAGE_MENU_INDEX);?>">
            <a class="nav-link" href="index.php"><i class="fa fa-home" aria-hidden="true"></i> หน้าแรก</a>
          </li>
          <li class="nav-item <?php selectedTopMenu(TOPMENU_INDEX_HELP,PAGE_MENU_INDEX);?>">
            <a class="nav-link" href="#"><i class="fa fa-book" aria-hidden="true"></i> วิธีใช้งาน</a>
          </li>
          <li class="nav-item <?php selectedTopMenu(TOPMENU_INDEX_RESERVATION,PAGE_MENU_INDEX);?>">
            <a class="nav-link" href="#"><i class="fa fa-bars" aria-hidden="true"></i> ลำดับผู้รอจัดสรรเข้าพักอาศัย</a>
          </li>
          
          <?php
          if($USER_LOGIN && $USER_GROUP===0){ ?>
            <!-- Member Services -->
            <li class="nav-item dropdown <?php selectedTopMenu(TOPMENU_INDEX_MEMBER,PAGE_MENU_INDEX);?>">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-archive" aria-hidden="true"></i> บริการสำหรับสมาชิก</a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <?php 
                if($USER_STATE===0){ ?>
                  <a class="dropdown-item" href="#"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ยื่นคำร้องขอเข้าพัก</a>
                  <a class="dropdown-item" href="#"><i class="fa fa-check-circle-o" aria-hidden="true"></i> สถานะการยื่นคำร้อง</a>
                <?php 
                }else if($USER_STATE===1){ ?>
                  <a class="dropdown-item" href="#"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ตรวจสอบบิลรายเดือน</a>
                  <a class="dropdown-item" href="#"><i class="fa fa-check-circle-o" aria-hidden="true"></i> แจ้งชำรุด</a>
                <?php 
                }?>
              </div>
            </li>
          <?php
          } ?>

          <?php
          if($USER_LOGIN && $USER_GROUP===1){ ?>
            <!-- Admin Menu -->
            <li class="nav-item dropdown <?php selectedTopMenu(TOPMENU_INDEX_ADMIN,PAGE_MENU_INDEX);?>">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-archive" aria-hidden="true"></i> เมนูสำหรับผู้ดูแลระบบ</a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="#"><i class="fa fa-circle-o" aria-hidden="true"></i> รายการใบจองห้องพัก</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i class="fa fa-circle-o" aria-hidden="true"></i> จัดการข้อมูลห้องพัก</a>
                <a class="dropdown-item" href="#"><i class="fa fa-circle-o" aria-hidden="true"></i> บิลรายเดือน</a>
                <a class="dropdown-item" href="#"><i class="fa fa-circle-o" aria-hidden="true"></i> แจ้งชำรุด</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i class="fa fa-circle-o" aria-hidden="true"></i> ชื่อบัญชีผู้ใช้</a>
                <a class="dropdown-item" href="#"><i class="fa fa-circle-o" aria-hidden="true"></i> ชื่อบัญชีกลุ่มผู้ดูแลระบบ</a>
              </div>
            </li>
          <?php
          } ?>

        </ul>

        <?php
        if($USER_LOGIN){
          
        ?>
          <!-- USER LOGIN -->
          <ul class="navbar-nav" style="min-width: 150px;">
            <li class="nav-item dropdown  <?php selectedTopMenu(TOPMENU_INDEX_USER_LOGIN,PAGE_MENU_INDEX);?>" style="width: 100%">
              <a class="nav-link dropdown-toggle text-right" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <?php echo $USER_DISPLAY_NAME;?></a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="profile.php"><i class="fa fa-address-card-o" aria-hidden="true"></i> บัญชีผู้ใช้</a>
                <a class="dropdown-item" href="#"><i class="fa fa-cog" aria-hidden="true"></i> ตั้งค่า</a>
                <a class="dropdown-item" href="#"><i class="fa fa-sign-out" aria-hidden="true"></i> ออกจากระบบ</a>
              </div>
            </li>
          </ul>
        <?php
        }else{
        ?>
          <!-- NORMAL -->
          <ul class="navbar-nav" style="min-width: 150px;">
            <li class="nav-item dropdown  <?php selectedTopMenu(TOPMENU_INDEX_USER_LOGIN,PAGE_MENU_INDEX);?>" style="width: 100%">
              <a class="nav-link dropdown-toggle text-right" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i> เข้าสู่ระบบ</a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="#"><i class="fa fa-address-card-o" aria-hidden="true"></i> สมัครสมาชิก</a>
                <a class="dropdown-item" href="#"><i class="fa fa-sign-in" aria-hidden="true"></i> เข้าสู่ระบบ</a>
              </div>
            </li>
          </ul>
        <?php
        }?>
        
      </div>
    </nav>
    <!-- End Fixed navbar -->

    <!-- Begin Page content -->
    <div class="container" style="padding-bottom:15px">
        <!-- Breadcrumb -->
        <?php
        if(count($PAGE_BREAD_CRUMB)){
          echo "<div class='row'>",
                  "<div class='col'>",
                    "<nav class='breadcrumb bg-mute'>";
                    foreach($PAGE_BREAD_CRUMB as $title => $link){
                      if(!empty($link)){
                        echo "<a class='breadcrumb-item' href='$link'>$title</a>";
                      }else{
                        echo "<span class='breadcrumb-item active'>$title</span>";
                      }
                    }
          echo      "</nav>",
                  "</div>",
                "</div>";
        }
        ?>
        <!-- End Breadcrumb -->


