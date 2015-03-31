<?php
	/**
	* Plugin Name: Email Verification
	* Description: This is the first level qualification to address random registrations.You can position this API anywhere on your website or inside a form and customise the look and feel to suit the style of your website.
	* Author: Identity Verification Services
	* Version:1.0
	* Author URI: https://wordpress.org/plugins/identity-verification-australia/developers/ 
	*/

	// Plugin Registration Block


	register_activation_hook( __FILE__,'ev_activate');

	function ev_activate(){
		global $wpdb;
		$table_name = $wpdb->prefix . "ev_configurations";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		     $sql = "CREATE TABLE $table_name (
		      configuration_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		      client_id VARCHAR(200) NOT NULL,
		      client_secret VARCHAR(200) NOT NULL,
		      redirect_url VARCHAR(200),
		      error_url VARCHAR(200)
		    );";
		    //reference to upgrade.php file
		    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		    dbDelta( $sql );
		}
	}

	// Plugin Deactivation Block

	register_deactivation_hook( __FILE__,'ev_deactivate');

	function ev_deactivate(){
		global $wpdb;
		$wpdb->query("DROP Table IF EXISTS ".$wpdb->prefix . "ev_configurations");
	}



	// Menu which should be displayed in Admin

	add_action("admin_menu",'ev_configurations');

	function ev_configurations(){
		add_menu_page("Email Verification","Email Verification","manage_options","email_verificaiton","ev_configuration_form");
	}


	// Configuration Form will be Displayed

	function ev_configuration_form(){
		global $wpdb;
		if($_POST){
			$configuration_id=array_shift($_POST);

			if($configuration_id!='')
			$wpdb->query("update ".$wpdb->prefix."ev_configurations set client_id='".$_POST['client_id']."',client_secret='".$_POST['client_secret']."',redirect_url='".$_POST['redirect_url']."',error_url='".$_POST['error_url']."' where configuration_id=".$configuration_id);
			else
			$wpdb->insert($wpdb->prefix."ev_configurations",$_POST);
			wp_redirect(site_url()."/wp-admin/admin.php?page=email_verificaiton");
		}

		$configuration_details=$wpdb->get_results("select * from ".$wpdb->prefix."ev_configurations");
		include("configuration_form.php");
	}


	// Email Verification Form

	function verification_form(){
		global $wpdb;
		$configuration_details=$wpdb->get_results("select * from ".$wpdb->prefix."ev_configurations");
		include("verification_form.php");
	}

	// Style Sheets

	add_action('wp_enqueue_scripts', 'ev_styles');
	
	function ev_styles() {
		
		wp_register_style('ev_style', plugins_url('css/ev_style.css', __FILE__));
		wp_enqueue_style('ev_style');
		
	}
	
	// Admin Styles

	add_action('admin_enqueue_scripts', 'ev_styles');

	// Scripts
	add_action('wp_enqueue_scripts', 'ev_scripts');
	
	function ev_scripts() {
		
		wp_enqueue_script('jquery');
		?>
<script>
	var site_url='<?php echo site_url()?>'
</script/>
	<?php
		wp_register_script('ev_script', plugins_url('js/ev_scripts.js', __FILE__));

		wp_enqueue_script('ev_script');
		
	}


	// Ajax call to Send Email 

	add_action("wp_ajax_verify_email", "ev_send_email_function");
	add_action("wp_ajax_nopriv_verify_email", "ev_send_email_function");

	function ev_send_email_function(){
		global $wpdb;
		$url='https://api.identityverification.com/get_verified/get_auth_token/';
		$api_credentials=$wpdb->get_results("select * from ".$wpdb->prefix ."ev_configurations");
		
		$config_auth['client_id']=$api_credentials[0]->client_id;
		$config_auth['client_secret']=$api_credentials[0]->client_secret;
		
		$auth_token_result=ev_sendPostData_api($url,json_encode($config_auth));
		
		// Mobile Number Verification 
		$_POST['auth_token']=$auth_token_result->auth_token;
		$_POST['redirect_url']=$api_credentials[0]->redirect_url;
		$_POST['error_url']=$api_credentials[0]->error_url;
		$email_verification_url='https://api.identityverification.com/get_verified/email/';
		$email_authentication_response=ev_sendPostData_api($email_verification_url,json_encode($_POST));
		echo $result=json_encode($email_authentication_response);
		exit;
	}



	// Ajax call to Send Email 

	add_action("wp_ajax_resend_email", "ev_resend_email_function");
	add_action("wp_ajax_nopriv_resend_email", "ev_resend_email_function");

	function ev_resend_email_function(){
		global $wpdb;
		$url='https://api.identityverification.com/get_verified/get_auth_token/';
		$api_credentials=$wpdb->get_results("select * from ".$wpdb->prefix ."ev_configurations");
		
		$config_auth['client_id']=$api_credentials[0]->client_id;
		$config_auth['client_secret']=$api_credentials[0]->client_secret;
		
		$auth_token_result=ev_sendPostData_api($url,json_encode($config_auth));
		
		// Mobile Number Verification 
		$_POST['auth_token']=$auth_token_result->auth_token;
		$_POST['redirect_url']=$api_credentials[0]->redirect_url;
		$email_verification_url='https://api.identityverification.com/get_verified/resend_email/';
		$email_authentication_response=ev_sendPostData_api($email_verification_url,json_encode($_POST));
		echo $result=json_encode($email_authentication_response);
		exit;
	}


	function ev_sendPostData_api($url,$post){
		  $ch = curl_init($url);
		  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		  $resulty = curl_exec($ch);
		  curl_close($ch);  // Seems like good practice
		  return json_decode($resulty);
	}


	add_shortcode( 'IVS_EMAIL_VERIFICATION', 'verification_form' );


?>