<?
// *******************************************************************
//  include/email_addition.php
// *******************************************************************

$recipient = $owner_name . " <" . $owner_email . ">";

$subject = $email_addition_1 . $site_title;

$content .= $email_addition_2 . "\n\n";
$content .= $email_addition_3 . stripslashes($SiteName) . "\n";
$content .= $email_addition_4 . $SiteURL . "\n\n";
$content .= $email_addition_5 . $base_url . "/admin/index.php\n\n";

$headers = "From: " . $UserName . "<" . $Email . ">\n";
$headers .= "X-Sender: <" . $owner_email . ">\n";
$headers .= "Return-Path: <" . $owner_email . ">\n";
$headers .= "Error-To: <" . $owner_email . ">\n";
$headers .= "X-Mailer: " . $SERVER_NAME . NewPHPLinks"\n";

mail($recipient, $subject, $content, $headers);

?>
