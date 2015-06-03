<?php
$wp_url = $_POST['wp_url'];
include($wp_url . 'wp-config.php');

$page = htmlentities($_POST['page']);
switch($page)
{
	case "login":
		/*
		$log = htmlentities($_POST['log']);
		$pwd = md5(htmlentities($_POST['pwd']));
		if(count_POST(BM_MEMBER_TBL,"WHERE username = '$log' AND password = '$pwd'") > 0)
		{
            $output = json_decode(query_Table(BM_MEMBER_TBL,"WHERE username = '$log' AND password = '$pwd'"));
			foreach ($output as $name => $value)
			{
				SetCookie("MEMBER_ID", $value->ID, time() + 86400, "/");
				echo '{ "status": "success", "message": "Accepted! Redirecting please wait..." }';  
			}
		}
		else
		{
			echo '{ "status": "failed", "message": "Access Denied!" }';  
		}
		*/
	break;
	case "logout":
		/*
		SetCookie("MEMBER_ID", "", time() - 86400, "/");
		echo '{ "status": "success", "message": "Successfully logged out!" }';  
		*/
	break;
	/*
	case "lostpassword":
		//send email
		$uemail = htmlentities($_POST['uemail']);
		if(count_POST(WOC_PARTICIPANTS,"WHERE username = '$uemail' || emailaddress = '$uemail'") > 0)
		{
            $output = json_decode(query_Table(WOC_PARTICIPANTS,"WHERE username = '$uemail' || emailaddress = '$uemail'"));
			foreach ($output as $name => $value)
			{
				$participantID = $value->ID;
				$emailaddress = $value->emailaddress;
				$unique_id = $value->unique_id;
				$mail = new Notifications($participantID,3);
				$mail->sendMail();
				echo '{ "status": "success", "message": "A reset password link has been sent. Please check your email to reset your password!" }';  
			}
		}
		else
		{
			echo '{ "status": "failed", "message": "Invalide username or email entered!" }';  
		}
	break;
	case "lostpasswordreset":
		$uid = $_POST['uid'];
		$password_unencrypted = htmlentities($_POST['newpassword']);
		$password =  md5(htmlentities($_POST['newpassword']));
		
		$sql = "
		UPDATE " . WOC_PARTICIPANTS . "
		SET 
			password = '$password'
		WHERE 
			ID = $uid
		";
		$wpdb->query($sql);
		echo '{ "status": "success", "message": "Your password has been successfully updated!" }';  		
	break;
	*/
}
?>