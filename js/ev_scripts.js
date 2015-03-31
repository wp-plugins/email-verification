jQuery(document).ready(function(){

	
	jQuery("#verify_ev").click(function(){
		var reg_email=/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if(jQuery("#email").val()==''){
			jQuery("#email").focus();
			jQuery("#email").css("border","1px solid red");
			jQuery(".err_email").text("Please Enter Email");
			return false;
		}
		else if(!reg_email.test(jQuery("#email").val())){
			jQuery("#email").focus();
			jQuery("#email").css("border","1px solid red");
			jQuery(".err_email").text("Please Enter Valid Email Eg:examle@yoursite.com");
			return false;
		}else{
			
			jQuery("#email").css("border","1px solid #dfdfdf");
			jQuery(".err_email").text("");
			
		}
		jQuery("body").css("opacity","0.5");
		jQuery(".loader_image").css("display","block");
		jQuery.ajax({
			url:site_url+'/wp-admin/admin-ajax.php?action=verify_email',
			type:'post',
			data:'email='+jQuery("#email").val(),
			success:function(result_ev){
			
			jQuery("body").css("opacity","1");
			jQuery(".loader_image").css("display","none");
				var d = JSON.parse(result_ev);
				jQuery("#sent_email").val(d.email);
				
				jQuery(".ivs-message_ev").css("display","block");
				jQuery(".ivs-message_ev").slideDown("slow");
				if(d.status=='valid'){
					jQuery(".ivs-message_ev").html("Email has been sent to your Inbox to verify (if not received please check your spam folder");
						jQuery(".resend-block").slideDown("slow")
				}else{
					jQuery(".ivs-message_ev").html(d.message);

				}
			}

		});
	});

	jQuery(".resend_email").click(function(){
		jQuery("body").css("opacity","0.5");
		jQuery(".loader_image").css("display","block");
		jQuery.ajax({
			url:site_url+'/wp-admin/admin-ajax.php?action=resend_email',
			type:'post',
			data:'email='+jQuery("#email").val(),
			success:function(result_ev){
			
			jQuery("body").css("opacity","1");
			jQuery(".loader_image").css("display","none");
				var d = JSON.parse(result_ev);
				jQuery("#sent_email").val(d.email);
				jQuery(".ivs-message_ev").slideDown("slow");
				if(d.status=='valid'){
					jQuery(".ivs-message_ev").html("Email has been sent to your Inbox to verify (if not received please check your spam folder");
				}else{
					jQuery(".ivs-message_ev").html(d.message);

				}
			}

		})
	});
	
});