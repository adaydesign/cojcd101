<?php
// it's have been include boostrap.js and jquery.js already
if(isset($USER_STATE) && $USER_STATE==0){ // Normal Member ?>

<script>
    $(function(){

        $("#btn_confirm_req, #btn_cancel_req").click(function(){
          event.preventDefault();
          
            var url_link    = "action/act_m1_req_confirm.php";
            var req_doc     = $(this).data("reqdoc");
            var req_confirm = $(this).data("comfirm");
            var values      = {"doc_req_id":req_doc, "doc_confirm":req_confirm};
    
            $.ajax({
                url : url_link,
                type: "POST",
                data: values,
                success: function(response){
                    console.log(response);

                    var obj = JSON.parse(response);
                    
                    $.notify({
                    title: "การยืนยันคำร้องขอเข้าพัก",
                    message: obj.message
                    },{
                        type: obj.result?'success':'danger'
                    });
    
                    if(obj.result){
                        // redirect to user_profile
                        window.setTimeout(function() {
                            window.location.replace("index.php");
                        },1500);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus, errorThrown);
                }
            });

        });
    });
</script>

<?php
} ?>