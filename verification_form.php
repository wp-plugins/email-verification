<img src="<?php echo plugins_url('/images/loader.gif' , __FILE__)?>" style="display:none" class="loader_image">

<?php
if(count($configuration_details)>0 && in_array  ('curl', get_loaded_extensions())){
?>

<div class="main-form-plg email">
	<div class="ivs-form">
		<h5>Email Verification</h5>
		<div class="ivs-message_ev alert-static"></div>
		<div class="ivs-inner">
			<div class="ivs-field-form">
				
				<div class="ivs-input">	
					<input type="text" name="email" id="email" placeholder="Email to be Verified"  >
					<span class="err err_email"></span>
					<div class="text-right">
						<button class="btn-ivs-form" id="verify_ev"> VERFY</button>  
						
					</div>		
				</div>		
				<div class="clear"></div>
			</div>
			
		</div>
		<div class="text-center">
			<div class="resend-block" style="display:none">
				<input type="hidden" id="sent_email">
				Still waiting for your Verification Link? Click 
				<button class="resend_email" >RESEND</button>
				
			</div>
		</div>
	</div>
</div>
<div class="clear"></div>
<?php
}else{
?>
<h3>API Credentials Not Provided.Please contact site Administrator</h3>
<?php
}
?>