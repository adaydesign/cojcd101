<?php

    $i_username = filter_input(INPUT_POST,"input_username",FILTER_SANITIZE_SPECIAL_CHARS);
    $i_password = filter_input(INPUT_POST,"input_password1",FILTER_SANITIZE_SPECIAL_CHARS);
    $i_pass_con = filter_input(INPUT_POST,"input_password2",FILTER_SANITIZE_SPECIAL_CHARS);
    $i_email    = filter_input(INPUT_POST,"input_email",FILTER_SANITIZE_SPECIAL_CHARS);
    $i_role     = filter_input(INPUT_POST,"input_role",FILTER_SANITIZE_SPECIAL_CHARS);
    $i_recaptcha= filter_input(INPUT_POST,"g-recaptcha-response",FILTER_SANITIZE_SPECIAL_CHARS);

    $result     = array("form"=>"register","result"=>false,"message"=>"พบข้อผิดพลาด");

    if($i_recaptcha){
        /*
        Google ReCaptcha site verify
        */
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = array("secret" => "6LdpTy8UAAAAAI_AAdFId8nWAB38LFKTctlBZC9A",
                      "response" => $i_recaptcha);
        
        $options = array('http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                         'method'  => 'POST',
                                         'content' => http_build_query($data)));
        $context  = stream_context_create($options);
        $contents = file_get_contents($url, false, $context);
        
        $res = json_decode($contents,true);
        if($res["success"]){
            // Password Verify
            if( strcmp($i_password,$i_pass_con)===0){
                include_once "../include/config.php";
                include_once "../model/database.class.php";

                // Check duplicate username
                $db = new Database();
                if($db->isConnected()){
                    $sql = "SELECT * FROM tb_users WHERE username=:username";
                    $db->query($sql);
                    $db->bind(":username",$i_username);
                    $db->execute();

                    if($db->rowCount()==0){
                        // Insert new user 
                        $sql2 = "INSERT INTO tb_users (username,password,email,register_date,user_state)
                        VALUES (:username,:password,:email,NOW(),:user_state)";
                        $db->query($sql2);
                        $sql2_v = array(":username"     => "$i_username",
                                        ":password"     => md5($i_password),
                                        ":email"        => "$i_email",
                                        ":user_state"   => "$i_role");
                        $db->bindValues($sql2_v);
                        if($db->execute()==true){
                            $result["result"] = true;
                            $result["message"]= "สมัครสมาชิกเรียบร้อยแล้ว กรุณากดปุ่มเข้าสู่ระบบ";
                        }else{
                            $result["result"] = false;
                            $result["message"]= "ไม่สามารถเพิ่มชื่อผู้ใช้ใหม่เข้าระบบได้ กรุณาลองอีกครั้ง";
                        }
                        $db->close();
                        
                    }else{
                        // username is duplicate
                        $db->close();
                        $result["result"] = false;
                        $result["message"]= "ชื่อ username:$i_username มีผู้ใช้แล้ว";
                    }
                }
                
            }else{
                $result["result"] = false;
                $result["message"]= "การยืนยันรหัสผ่านไม่เหมือนกัน";
            }
        }else{
            $result["result"] = false;
            $result["message"]= "การยืนยันด้วย ReCaptcha พบข้อผิดพลาด ".$i_recaptcha;
        }
    }else{
        $result["result"] = false;
        $result["message"]= "กรุณาทำการยืนยันการไม่ใช้บอทด้วย ReCaptcha";
    }

    echo json_encode($result);
?>