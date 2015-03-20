
<div class="wrap ivs-bc">
	<h2>Email Verification </h2>
	<hr>
	<div class="setting">

		<h3> Client Key & Client Secret</h3>
		<form action="" method="post"> 
			
			<table class="form-table">
				<tbody>
					<tr>
						<td>
							Client Id		
						</td>
					
						<td>
							<input name="setting_id" value="<?php echo (count($configuration_details)>0?$configuration_details[0]->configuration_id:'')?>" type="hidden"/> 
							<input name="client_id" placeholder="Client Id" type="text" required value="<?php echo (count($configuration_details)>0?$configuration_details[0]->client_id:'')?>"/> 
						</td>
					</tr>
					<tr>
						<td>
							Client Secret		
						</td>
					
						<td>
							<input name="client_secret" placeholder="Client Secret" type="text"  required value="<?php echo (count($configuration_details)>0?$configuration_details[0]->client_secret:'')?>"/> 
						</td>
					</tr>
						<tr>
						<td>
							Redirect Url
						</td>
						<td>
							<input type="text"  name="redirect_url" required value="<?php echo (count($configuration_details)>0?$configuration_details[0]->redirect_url:'')?>">
						</td>
					</tr>
					<tr>
						<td>
							Error Url
						</td>
						<td>
							<input type="text"  name="error_url" required value="<?php echo (count($configuration_details)>0?$configuration_details[0]->error_url:'')?>">
						</td>
					</tr>
					
			<tr>
				<td>
				</td>
				<td class="td-btn">
					<input  type="submit" value="Save" class="btn"/> 
				</td>
			</tr>
					</tbody>
			</table>

		</form>
		<hr>
		<div class="update-nag">
		<?php
		if(count($configuration_details)>0 && $configuration_details[0]->client_id!=''){
		?>
		ShortCode [IVS_EMAIL_VERIFICATION]
		<?php
		}else{

			echo "Please Provide Client API Credentials to get Short Code";
		}
		?>
	</div>

	</div>
	


</div>