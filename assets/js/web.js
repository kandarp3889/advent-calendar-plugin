jQuery(document).ready(function($) {


  $(".openedbox").click(function(){
      $(this).addClass('magictime perspectiveLeft');
      $(this).parent(".innerc").addClass("inner_box");
      $(".dayid").val($(this).parent('div').attr('data'));
      setTimeout(function(){
        $(".promopopup").addClass('magictime swashIn');
        $(".promopopup").css("display","block");
        
           
    }, 500);
    });
    $(".openblankbox").click(function(){
      $(this).addClass("imgrumb");
      setTimeout(function(){
        $(".imgrumb").removeClass("imgrumb");
        $(".innerc").removeClass("inner_box");
    }, 2000);
    });
    $(document).find(".promoclose").on('click',function(){
         $(".promopopup").css("display","none");
         $(".magictime").removeClass('perspectiveLeft');
         $(".innerc").removeClass("inner_box");
        
    });
    $(document).find(".promosucessclose").on('click',function(){
        $(".promopopup").css("display","none");
        $(".promoboxsucess").css("display","none");
        $(".promobox").css("display","block");
        $(".magictime").removeClass('perspectiveLeft');
    $(".innerc").removeClass("inner_box");
   });
     
    $('#ac-userform').submit(function(e){       
        var rule=0;
        if($('#meiner').prop("checked") == true){
             rule=1;
        }
        $(".ac_error").remove();
            $.ajax({
              type:'POST',
              dataType: "text",
              data:{
                  'action': 'ac_form_data',
                  'name': $(".user_name").val(),
                  'email': $(".user_email").val(),
                  'dayid': $(".dayid").val(),
                  'terms' : '1',
                  'rule' : rule
                },
              url: $(".requesturl").val()+"/wp-admin/admin-ajax.php",
              success: function(data) {  
                var data = $.trim(data);
                if(data == 0 ){
                    $(".promcode_header").after('<div class="ac_error">Somthing Wrong!please tray again</div>');
                }
                if(data == 1){
                  $(".promcode_header").after('<div class="ac_error">Mit dieser Email wurde das Türchen bereits geöffnet.</div>');
                }
                else
                {   $(".promobox").css("display","none");
                    $(".promoboxsucess").css("display","block");
                    $(".promosucess").html('<div class="promocode_final">'+data+'</div>');
                }
              }
            });
        });
    
})
/*$(document).ready(function(){
    
    
   
 });*/