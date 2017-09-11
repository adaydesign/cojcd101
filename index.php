<?php
  // check session, if required
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
    // require login
    // redirect to
    header("Location: main.php");
    die();
  }
?>

<!DOCTYPE html>
<?php include_once "include/config.php"; ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicon.ico">

    <title><?php echo SYS_NAME;?></title>

    <!-- Bootstrap core CSS -->
    <link href="lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/cover.css" rel="stylesheet">
    <link href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <script src='https://www.google.com/recaptcha/api.js'></script>

  </head>

  <body>

    <div class="site-wrapper">
      <div class="site-wrapper-inner">

        <div class="cover-container">
          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">COJ CONDO</h3>
              <nav class="nav nav-masthead">
                <a class="nav-link active" href="#">หน้าแรก</a>
                <!--<a class="nav-link" href="#">วิธีการใช้งาน</a>-->
                <a class="nav-link" href="#">ลำดับผู้รอจัดสรรเข้าพักอาศัย</a>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading"><?php echo SYS_NAME;?></h1>
            <p class="lead">ระบบช่วยอำนวยความสะดวกให้แก่ข้าราชการศาลยุติธรรมที่ต้องการจองที่พักอาศัยในเขตกรุงเทพมหานคร พร้อมบริการการรับแจ้งค่าบิลรายเดือนและแจ้งคุรุภัณฑ์ชำรุด</p>
            <p class="lead">
              <button type="button" class="btn btn-lg btn-secondary" data-toggle="modal" data-target="#register_modal"><i class="fa fa-pencil" aria-hidden="true"></i> สมัครสมาชิก</button>
              <button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#login_modal"><i class="fa fa-user-circle-o" aria-hidden="true"></i> เข้าสู่ระบบ</button>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p><?php echo SYS_NAME;?> เวอร์ชั่น <?php echo SYS_VERSION;?> พัฒนาโดย <a href="#">คณะทำงานกลุ่ม 5</a>.</p>
            </div>
          </div>


          <!-- Modal : Register -->
          <div class="modal fade" id="register_modal" tabindex="-1" role="dialog" aria-labelledby="register_modal_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content" style="color:#000;text-shadow:none;text-align: left;">
                <div class="modal-header">
                  <h5 class="modal-title" id="register_modal_label"><i class="fa fa-pencil" aria-hidden="true"></i> สมัครสมาชิก</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form id="form_register">
                  <div class="modal-body">

                    <!-- alert -->
                    <div class="form-group row">
                      <div class="col" id="alert_reg" style="display:none;">
                        <!--<div class="alert alert-primary" role="alert">
                          This is a primary alert—check it out!
                        </div>-->
                      </div>
                    </div>

                    <!-- username -->
                    <div class="form-group row">
                      <label for="input_username" class="col-sm-3 col-form-label">ชื่อผู้ใช้งาน</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="input_username" id="input_username" maxlength="20" placeholder="ตั้งชื่อผู้ใช้งาน" required>
                      </div>
                    </div>
                    
                    <!-- password -->
                    <div class="form-group row">
                      <label for="input_password1" class="col-sm-3 col-form-label">รหัสผ่าน</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" name="input_password1" id="input_password1" maxlength="20" placeholder="ตั้งรหัสผ่าน" required>
                      </div>
                    </div>
                    
                    <!-- confirm password -->
                    <div class="form-group row">
                      <label for="input_password2" class="col-sm-3 col-form-label">ยืนยันรหัสผ่าน</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" name="input_password2" id="input_password2" maxlength="20" placeholder="ยืนยันรหัสผ่าน" required>
                      </div>
                    </div>
                    
                    <!-- email -->
                    <div class="form-group row">
                      <label for="input_email" class="col-sm-3 col-form-label">อีเมล</label>
                      <div class="col-sm-9">
                        <input type="email" class="form-control" name="input_email" id="input_email" maxlength="50" placeholder="ใส่อีเมล" required>
                      </div>
                    </div>

                    <!-- Resident Status -->
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">สถานะผู้พักอาศัย</label>
                      <div class="col-sm-9">
                          <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="input_role" value="0" checked>
                                ต้องการยื่นขอจองอาคารที่พัก
                              </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="input_role" value="1">
                                เป็นผู้พักอาศัยอยู่เดิม
                              </label>
                            </div>
                      </div>
                    </div>
                    
                    <!-- CAPTCHA -->
                    <div class="form-group row">
                      <label for="recp" class="col-sm-3 col-form-label"></label>
                      <div class="col-sm-9">
                        <!-- Google ReCaptcha Here -->
                        <div class="g-recaptcha" data-sitekey="6LdpTy8UAAAAALTweF0e2veaXUC3N8imx3zAr2Ru"></div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" id="submit_register" class="btn btn-primary">สมัครสมาชิก</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- End Modal : Register -->

          <!-- Modal : Login -->
          <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="login_modal_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content" style="color:#000;text-shadow:none;text-align: left;">
                <div class="modal-header">
                  <h5 class="modal-title" id="login_modal_label"><i class="fa fa-user-circle-o" aria-hidden="true"></i> เข้าสู่ระบบ</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form id="form_login">
                  <div class="modal-body">
                    <!-- alert -->
                    <div class="form-group row">
                      <div class="col" id="alert_login" style="display:none;">
                        <!--<div class="alert alert-primary" role="alert">
                          This is a primary alert—check it out!
                        </div>-->
                      </div>
                    </div>
                    <!-- username -->
                    <div class="form-group row">
                      <label for="login_username" class="col-sm-3 col-form-label">ชื่อผู้ใช้งาน</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="login_username" id="login_username" maxlength="20" placeholder="ชื่อผู้ใช้งาน" required>
                      </div>
                    </div>
                    <!-- password -->
                    <div class="form-group row">
                      <label for="login_password1" class="col-sm-3 col-form-label">รหัสผ่าน</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" name="login_password" id="login_password" maxlength="20" placeholder="รหัสผ่าน" required>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- End Modal : Login -->

        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="lib/jquery/dist/jquery.min.js"></script>
    <script src="lib/popper.js/popper-1-11-0.min.js"></script>
    <script src="lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="lib/backstretch/jquery.backstretch.js"></script>

    <script>
      $(function(){

        // backstretch
        $.backstretch("assets/images/bg101.jpg");

        // form register submit
        $("#form_register").submit(function(event){
          // Stop form from submitting normally
          event.preventDefault();

          var url_link = "action/act_register.php";
          var values   = $(this).serialize();

          $.ajax({
              url : url_link,
              type: "POST",
              data: values,
              success: function(response){
                  // console.log(response);
                  var obj = JSON.parse(response);
                  // console.log(obj.result);
                  var form = obj.form;
                  var alert_color = "alert-warning";

                  if(form=="register"){
                    if(obj.result==false){
                      // if false, reset current recaptcha widget_id
                      // https://developers.google.com/recaptcha/docs/display
                      grecaptcha.reset();
                    }else{
                      // success
                      alert_color = "alert-success";
                      
                      // reset form, recaptcha
                      $("#form_register")[0].reset();
                      grecaptcha.reset();
                      
                      window.setTimeout(function() {
                        $("#alert_reg").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                            $("#register_modal").modal('hide');
                        });
                      }, 1500);
                    }
                  }
                  
                  var msg = "<div class='alert "+alert_color+" text-center' role='alert'>"+obj.message+"</div>";
                  $("#alert_reg").html(msg);
                  $("#alert_reg").show();

              },
              error: function(jqXHR, textStatus, errorThrown){
                  console.log(textStatus, errorThrown);
              }
          });
        
        });

        // form login
        $("#form_login").submit(function(event){
          // Stop form from submitting normally
          event.preventDefault();

          var url_link = "action/act_login.php";
          var values   = $(this).serialize();

          $.ajax({
              url : url_link,
              type: "POST",
              data: values,
              success: function(response){
                  // console.log(response);
                  var obj = JSON.parse(response);
                  // console.log(obj.result);
                  var form = obj.form;
                  var alert_color = "alert-danger";
                  var icon = "";
                  if(form=="login"){
                    if(obj.result==true){
                      alert_color = "alert-success";
                      icon = " <i class='fa fa-circle-o-notch fa-spin fa-fw'></i><span class='sr-only'>Loading...</span>";
                      window.setTimeout(function() {
                        $("#alert_login").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                            $("#login_modal").modal('hide');
                            $("#form_login")[0].reset();
                            // redirect to home page
                            window.location.replace("main.php");
                        });
                      }, 1500);
                    }else{
                      $("#login_password").val("");
                    }
                  }
                  
                  var msg = "<div class='alert "+alert_color+" text-center' role='alert'>"+obj.message+icon+"</div>";
                  $("#alert_login").html(msg);
                  $("#alert_login").show();

              },
              error: function(jqXHR, textStatus, errorThrown){
                  console.log(textStatus, errorThrown);
              }
          });
        
        });

      });

    </script>

  </body>
</html>
