<?php

// Replace this with your own email address
$siteOwnersEmail = 'dev.zainali@gmail.com';

if($_POST) {

	$name = trim(stripslashes($_POST['contactName']));
	$email = trim(stripslashes($_POST['contactEmail']));
	$subject = trim(stripslashes($_POST['contactSubject']));
	$contact_message = trim(stripslashes($_POST['contactMessage']));
	$error = array();

	// Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Please enter your name.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Please enter a valid email address.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Your message should have at least 15 characters.";
	}
	// Subject
	if ($subject == '') {
		$subject = "Contact Form Submission";
	}


	// Set Message
	$message = "Email from: " . $name . "<br />";
	$message .= "Email address: " . $email . "<br />";
	$message .= "Message: <br />";
	$message .= $contact_message;
	$message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

	// Set From: header
	$from =  $name . " <" . $email . ">";

	// Email Headers
	// $headers = "From: " . $from . "\r\n";
	// $headers .= "Reply-To: ". $email . "\r\n";
	// $headers .= "MIME-Version: 1.0\r\n";
	// $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$to = 'developerzainali@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
	$email_subject = "Website Contact Form:  $name";
	$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n$message";
	$headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
	$headers .= "Reply-To: $email_address";

	if ( empty($error) ) {

		//ini_set("sendmail_from", $siteOwnersEmail); // for windows server
		$mail = 	mail($to,$email_subject,$email_body,$headers);

		if ($mail) {
			$error['OK'] = "done";
			echo json_encode($error);
		} else {
			$error['sending'] = "Something went wrong. Please try again.";
			echo json_encode($error);
		}

	} # end if - no validation error

	else {

		echo json_encode($error);

	} # end else - there was a validation error

}

?>
