<img src="<?php echo plugins_url('/images/loader.gif' , __FILE__)?>" style="display:none" class="loader_image">

<?php
if(count($configuration_details)>0){
?>
<div class="ivs-form1">
	<div class="ivs-message_ev alert-static"></div>
	<div class="ivs-inner-form">
		<div class="ivs-field">
			<label for="driving_license">Email</label>
			<div class="ivs-input">	
				<input type="text" name="email" id="email" placeholder="Email to be Verified" style="width:70% !important;float:left;margin-left:5px" ><a  class="" href="#" id="verify_ev" >VERIFY</a>
				<span class="err err_email"></span>
			</div>		
			<div class="clear"></div>
		</div>
		
	</div>
	<div class="resend-block" style="display:none">
		<input type="hidden" id="sent_email">
		Still waiting for your Verification Link? Click <a href="#?" class="resend_email">RESEND</a><br/><br/>
		
	</div>
</div>
<?php
}else{
?>
<h3>API Credentials Not Provided.Please contact site Administrator</h3>
<?php
}
?>