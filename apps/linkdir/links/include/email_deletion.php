<?
// *******************************************************************
//  include/email_deletion.php
// *******************************************************************

$query = sql_query("
	select
		*
	from
		$tb_temp
	where
		ID='$ID'
");

$array = sql_fetch_array($query);

$recipient = $array[UserName] . "<" . $array[Email] . ">";

$subject = $email_deletion_1 . $site_title;

$content .= $email_deletion_2 . $site_title . "\n\n";
$content .= $email_deletion_3 . stripslashes($array[SiteName]) . "\n";
$content .= $email_deletion_4 . $array[SiteURL] . "\n\n";
$content .= $email_deletion_5 . ",\n\n";
$content .= "--\r\n" . $owner_name . " <" . $owner_email . ">\n\n";

$headers = "From: " . $owner_name . " <" . $owner_email . ">\n";
$headers .= "X-Sender: <" . $owner_email . ">\n";
$headers .= "Return-Path: <" . $owner_email . ">\n";
$headers .= "Error-To: <" . $owner_email . ">\n";
$headers .= "X-Mailer: " . $SERVER_NAME . NewPHPLinks"\n";

mail($recipient, $subject, $content, $headers);
?>
