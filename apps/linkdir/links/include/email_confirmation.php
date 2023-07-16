<?
// *******************************************************************
//  include/email_confirmation.php
// *******************************************************************

$recipient = $UserName . "<" . $Email . ">";

$subject = $email_confirmation_1 . $site_title;

$content .= $email_confirmation_2 . $site_title . "\n\n";
$content .= $email_confirmation_3 . stripslashes($SiteName) . "\n";
$content .= $email_confirmation_4 . $SiteURL . "\n\n";
$content .= $email_confirmation_5 . "\n";
$content .= "<a href=\"" . $base_url . "/in.php?ID=" . $id . "\" target=\"_blank\">";
$content .= $site_title . "</a>\n\n";
$content .= $email_confirmation_6 . "\n\n";
$content .= $email_confirmation_7 . ",\n\n";
$content .= "--\r\n" . $owner_name . " <" . $owner_email . ">\n\n";

$headers = "From: " . $owner_name . " <" . $owner_email . ">\n";
$headers .= "X-Sender: <" . $owner_email . ">\n";
$headers .= "Return-Path: <" . $owner_email . ">\n";
$headers .= "Error-To: <" . $owner_email . ">\n";
$headers .= "X-Mailer: " . $SERVER_NAME . NewPHPLinks"\n";

mail($recipient, $subject, $content, $headers);

?>
