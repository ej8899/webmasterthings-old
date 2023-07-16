<?php

//Default e-mail address. This is only used if a 'to' isn't specified in the forum
$adminmail	= 'unspecifieduser@webmasterthings.com';
$ccmail		= 'mrcoyote@gmail.com';	// if force cc to admin is 1

// force a cc of email to var ccmail
$forcecc	= 1;		// 1 =yes

//Set equal to 1 if you want the data to be sorted alphabetically
$sort		= 0;

//This is the delimiter that is used for each $key value in the e-mail. Just play around with it.
$delim		= '';

//Set equal to 1 if you want to check referring hosts.
$refcheck	= 0;

//These are the allowed refferers. If $refcheck above is not set equal to 1, this wont be checked.
//Separate these fields by a ',' (comma)
$referrers	= array('www.tcmd.com','tcmd.com');



//This will get rid of a $message variable. The data is still stored in the $HTTP_GET/POST_VARS array though
unset($message);

//Check for valid referrer
$referer = getenv('HTTP_REFERER');
//Check to make sure there is a referrer
if(empty($referer)){ 
	return_text("This is not a stand alone script. You must submit data to this via a web form.");
}

$ref_ok=0;
for($i=0;$i<count($referrers);$i++) {
	if($refcheck!=1){
		$ref_ok=1;
		break;
	}
	if(eregi("^https?:\/\/$referrers[$i]",$referer)) {
		$ref_ok=1;
		
		break;
	}
}

$host = preg_replace("|^https?://([\w\.]+)|","\\1",$referer);
$host = preg_replace("|([\w\.]+)/(.*)?|","\\1",$host);
if($ref_ok != 1) {
	return_text("Referring server is not allowed. You need to add contact WebmasterThings.com for access.");
}

//Start of the Mail Message

//Clean Up the GET method variables
if(!empty($HTTP_GET_VARS)){
	unset($get_data);

	while (list ($key,$value) = each ($HTTP_GET_VARS)) {
		if($key=='redirect' || $key=='to' || $key=='subject' || $key=='submit' || $key=='wt_owner') {} else {
			$get_data[$key]=$value;
		}
	}
}

//Clean Up the POST method variables
if(!empty($HTTP_POST_VARS)){
	unset($post_data);

	while (list ($key,$value) = each ($HTTP_POST_VARS)) {
		if($key=='redirect' || $key=='to' || $key=='subject' || $key=='submit' || $key=='wt_owner') {} else {
			$post_data[$key]=$value;
		}
	}
}

if($sort == 1) {
    @ksort($get_data);
    @ksort($post_data);
}

//Add GET data to the message
if(!empty($get_data)){
	while (list ($key,$value) = each ($get_data)) {
		$message .= "\n$delim$key:\n$value\n";
	}
}

//Add POST data to the message
if(!empty($post_data)){
	while (list ($key,$value) = each ($post_data)) {
		$message .= "\n$delim$key:\n$value\n";
	}
}

//End of the message
$message .= "\r\n---------------------------------------------------\r\n";
$message .= "Sent via FormPro at WebmasterThings.com ($wt_owner)\r\nSent via IP $REMOTE_ADDR on ".date("m/d/Y, h:i A");

// Strip PHP's slashes
if(stripslashes($message) != $message) {
	$message = stripslashes($message);
}

//Check for an email field
if(empty($email)) {
	$email = $adminmail;
}

//Check for a Subject Line
if(empty($subject)) {
	$subject = "Form Submission";
}

//Check for 'realname' field
if(empty($realname)) {
	$realname = $email;
}

//Add name to $email
$email .= " ($realname)";

//Send the E-mail
$to = 		clean_input_4email($to);
$subject = 	clean_input_4email($subject);
$email = 	clean_input_4email($email);
$message = 	clean_input_4email($message);


//
// verify to address
// only send if its valid
//
if (eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$", $to)) 
{
	mail($to, $subject, $message,"From: $email\r\nReply-To: $email\r\nX-Mailer: WebmasterThings.com");

	// forced cc to admin
	if($forcecc)
	{
		$subject="FORMRPO COPY: ".$subject;
		$message="---\r\nTO:$to\r\nFROM:$from\r\nSUBJECT:$subject\r\nREFERER:$referer\r\n---[ MESSAGE TO FOLLOW ]---".$message;
		mail($ccmail, $subject, $message,"From: $email\r\nReply-To: $email\r\nX-Mailer: WebmasterThings.com");
	}

	//Redirect
	if(empty($redirect)){
		return_text("Thank you for filling out the forum. You can return to the previous page right <a href=\"$HTTP_REFERER\">here</a>.");
	} else {
		header("Location: $redirect");
	}
}
else
{
	return_text("no.");
}

function return_text($text) {
  ?>
		  <html>
		  <html>
		  <head>
		  <title>Your Email Form</title>
		  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		  <style TYPE="text/css">
		  <!--
		  A:link, A:visited { text-decoration: none }
		  A:hover { text-decoration: underline; color: ffffff }
		  -->
		  </style>
		  </head>

		  <body bgcolor="#CCCCCC" text="#000000" link="#FFFF33" vlink="#FFFF33" alink="#330099">

		  <table width="600" border="1" cellspacing="0" cellpadding="2" align="center">
			<tr bgcolor="#999999" valign="top"> 
			  <td> 
				<div align="center">
				  <hr>
				  <table width="600" border="0" cellspacing="0" cellpadding="2">
					<tr>
					  <td valign="top"> 
					  <p><font face="Arial, Helvetica, sans-serif" size="2"><center>
		  <?php
		   echo $text;
		   echo "";
		  ?>
			 </center>
			</font>
			</p>
		   </td>
		  </tr>
		 </table>
		</body>
		</html>
   <?

   exit;
}


//clean input in case of header injection attempts!
function clean_input_4email($value, $check_all_patterns = true)
{
 $patterns[0] = '/content-type:/';
 $patterns[1] = '/to:/';
 $patterns[2] = '/cc:/';
 $patterns[3] = '/bcc:/';
 if ($check_all_patterns)
 {
  $patterns[4] = '/\r/';
  $patterns[5] = '/\n/';
  $patterns[6] = '/%0a/';
  $patterns[7] = '/%0d/';
 }
 //NOTE: can use str_ireplace as this is case insensitive but only available on PHP version 5.0.
 return preg_replace($patterns, "", strtolower($value));
}



?>