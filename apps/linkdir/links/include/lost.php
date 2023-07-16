<?
// *******************************************************************
//  include/lost.php
// *******************************************************************

unset($html);

$html = $table2 . "<tr><td class=\"whatText\">" . $lost_1;
$html .= "</td></tr></table>";

echo whattable("100%","center","",$html);
unset($html);

if(isset($get_password)){

	$html .= $table2 . "<tr><td class=\"regularText\" align=\"center\"><br />";

	$sql = sql_query("
		select
			*
		from
			$tb_links
		where
			Email='$Email'
		and
			ID='$ID'
	");

	if(sql_num_rows($sql)>0){

		$rows = sql_fetch_array($sql);

		$recipient = $rows[UserName] . "<" . $rows[Email] . ">";

		$subject = $lost_2;

		$content = $lost_3 . "\n";
		$content .= $lost_4 . $site_title . $lost_5 . "\n";
		$content .= $lost_6 . $SERVER_NAME . ".\n\n";
		$content .= $lost_7 . $rows[UserName] . "\n";
		$content .= $lost_8 . $rows[Hint] . "\n\n";
		$content .= $lost_9 . $base_url . "/index.php?show=update&amp;ID=";
		$content .= $ID . "\n\n" . $lost_10 . ",\n\n";
		$content .= "--\r\n" . $owner_name . " <" . $owner_email . ">\n\n";

		$headers = "From: " . $owner_name . " <" . $owner_email . ">\n";
		$headers .= "X-Sender: <" . $owner_email . ">\n";
		$headers .= "Return-Path: <" . $owner_email . ">\n";
		$headers .= "Error-To: <" . $owner_email . ">\n";
		$headers .= "X-Mailer: " . $SERVER_NAME . "\n";

		mail($recipient, $subject, $content, $headers);

		$html .= $lost_11 . $Email . $lost_12 . ".";
		
	} else {

		$html .= $lost_13 . $Email . "." . $lost_14;
		$get_password_error = 1;
	}

	$html .= "<br /><br /></td></tr></table>";
}

echo table("100%","center","",$html);
unset($html);

if(!isset($get_password) || isset($get_password_error)){
	
	$html = "<form method=post action=\"index.php?" . session_name() . "=";
	$html .= session_id() . "&amp;show=lost&amp;ID=" . $ID . "\">";
	$html .= $table2 . "<tr><td align=\"center\" class=\"regularText\">";
	$html .= $lost_15 . "</td></tr><tr><td ";
	$html .= "class=\"regularText\" align=\"center\"><input class=\"textBox\" ";
	$html .= "type=\"text\" name=\"Email\" size=\"20\"></td></tr><tr><td ";
	$html .= "align=\"center\"><input type=\"submit\" name=\"get_password\" ";
	$html .= "value=\"" . $lost_16 . "\"></td></tr></table></form>";
}

echo table("100%","center","",$html);
unset($html);

?>
