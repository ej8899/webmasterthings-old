<?
// *******************************************************************
//  include/update.php
// *******************************************************************

unset($html);

$htmlsrc = $table2 . "<tr><td class=\"whatText\">Update Site Listing: ";
$htmlsrc .= "</td></tr></table>";

echo whattable("100%","center","",$htmlsrc);
unset($htmlsrc);

if(
	!session_is_registered("LinkID") && 
	!isset($validate_login) && 
	!isset($finished_update)
){

	$html = $table . "<tr>";
	$html .= "\r\n\t<td class=\"regularText\">" . $update_1 . " " . $update_2;
	$html .= "<a class=\"regularText\" href=\"index.php?" . session_name() . "=";
	$html .= session_id() . "&amp;show=lost&amp;ID=";
	$html .= $ID . "\">" . $update_3 . "</a>" . $update_4 . "</td>\r\n</tr>\r\n";
	$html .= "</table>\r\n";
}

if(isset($html)){
	
	$final_html = table("100%","center","",$html);
	unset($html);
}

if(
	
	isset($validate_login) && 
	!session_is_registered("LinkID")
){

	$sql = sql_query("
		select
			*
		from
			$tb_links
		where
			ID='$ID'
		and
			UserName = '$UserName'
		and
			Password = password('$Password')
	");

	if(sql_num_rows($sql) > 0){

		$rows = sql_fetch_array($sql);
		$LinkID = $rows[ID];
		session_register("LinkID");

	} else {

		$validate_login_error = 1;

		$html = "<br />" . $table . "<tr><td class=\"regularText\">" . $update_6 . "<br />";
		$html .= "<a class=\"regularText\" href=\"index.php?" . session_name();
		$html .= "=" . session_id() . "&amp;show=lost&amp;ID=";
		$html .= $ID . "\">" . $update_3 . "</a>" . $update_4 . "</td></tr></table>";

	}
}

if(isset($html)){
	$final_html .= table("100%","center","",$html);
	unset($html);
}

if(isset($update_link)){
	
	$get_specs = sql_query("
		select
			*
		from
			$tb_specs
		where
			ID='1'
	");

	$spec = sql_fetch_array($get_specs);

	unset($error);

	if(strlen($SiteName) > $spec[SiteNameMax]){
		
		$error = 1;
		$site_name_error = 1;
	}

	if(strlen($SiteName) < $spec[SiteNameMin]){
		
		$error = 1;
		$site_name_error = 1;
	}

	if($SiteURL == "http://"){
		
		$SiteURL = "";
	}

	if($url_validate == "Y"){

		if(!$get_url = @fopen($SiteURL,"r")){
			
			$error = 1;
			$site_url_error = 1;
		}
	}

	if(strlen($Description) > $spec[DescMax]){
		
		$error = 1;
		$description_error = 1;
	}

	if(strlen($Description) < $spec[DescMin]){
		
		$error = 1;
		$description_error = 1;
	}

	if(strlen($Country) == 0){
		
		$error = 1;
		$country_error = 1;
	}

	if(strlen($UserName) < $spec[UserNameMin]){
		
		$error = 1;
		$user_name_error = 1;
	}

	if(strlen($UserName) > $spec[UserNameMax]){
		
		$error = 1;
		$user_name_error = 1;
	}

	if(strlen($Password) > 0){

		$update_pass = 1;

		if(strlen($Password) < $spec[PWMin]){
			
			$error = 1;
			$password_error = 1;
		}

		if(strlen($Password) > $spec[PWMax]){
			
			$error = 1;
			$password_error = 1;
		}

		if($Password != $Password2){
			
			$error = 1;
			$password2_error = 1;
		}

	}

	if(strlen($Hint) < $spec[HintMin]){
		
		$error = 1;
		$hint_error = 1;
	}

	if(strlen($Hint) > $spec[HintMax]){
		
		$error = 1;
		$hint_error = 1;
	}

	if(!ereg($spec[EmailSpec], $Email)){
		
		$error = 1;
		$email_error = 1;
	}

	if(!isset($error)){

		if($update_pass == 1){
			
			$sql = sql_query("
				update
					$tb_links
				set
					SiteName='$SiteName',
					SiteURL='$SiteURL',
					Description='$Description',
					Category='$Category',
					Country='$Country',
					Email='$Email',
					$Password=password('$Password'),
					Hint='$Hint'
				where
					ID='$ID'
			");

		} else {
			
			$sql = sql_query("
				update
					$tb_links
				set
					SiteName='$SiteName',
					SiteURL='$SiteURL',
					Description='$Description',
					Category='$Category',
					Country='$Country',
					Email='$Email',
					Hint='$Hint'
				where
					ID='$ID'
			");
		}

		$html = "<br />" . $update_7 . "<a href=\"index.php?" . session_name();
		$html .= "=" . session_id() . "&amp;show=owner&amp;ID=" . $ID;
		$html .= "\">" . $update_40 . "</a>" . $update_8 . "<br />";

	} else {
		
		$html = "<br /><font class=\"errorTextBold\">" . $update_9 . "</font><br /><br />";
	}
}

if(isset($html)){

	$html_ = $table . "<tr><td class=\"regularText\" align=\"center\">";
	$html_ .= $html . "</td></tr></table>";

	$final_html .= table("100%","center","",$html_);
	
	unset($html);
	unset($html_);
}

if(
	(
		session_is_registered("LinkID") && 
		!isset($validate_login_error)
	) ||
	isset($error)
){

	$sql = sql_query("
		select
			*
		from
			$tb_links
		where
			ID='$LinkID'
	");

	$rows = sql_fetch_array($sql);

	$html = "<br /><form method=\"post\" action=\"index.php?" . session_name() . "=";
	$html .= session_id() . "&amp;show=update&amp;ID=" . $LinkID . "\"><input ";
	$html .= "type=\"hidden\" name=\"finished_update\" value=\"1\" />";
	$html .= $form_table . "<tr><td class=\"regularText\">" . $update_11;
	$html .= "</td><td><input class=\"textBox\" type=\"text\" name=\"SiteName\"";
	$html .= " size=\"35\" value=\"" . $rows[SiteName] . "\" />";

	if(isset($site_name_error)){
		
		$html .= "<br /><font class=\"errorText\">" . $update_12 . $update_13;
		$html .= $spec[SiteNameMin] . $update_14 . $spec[SiteNameMax];
		$html .= $update_15 . "</font>";
	}
	
	$html .= "</td></tr><tr><td class=\"regularText\">" . $update_18 . "</td><td><input ";
	$html .= "class=\"textBox\" type=\"text\" name=\"SiteURL\" size=\"35\" ";
	$html .= "value=\"" . $rows[SiteURL] . "\" />";
	
	if(isset($site_url_error)){
		
		$html .= "<br /><font class=\"errorText\">" . $update_16 . "</font>";
	}

	$html .= "</td></tr><tr><td class=\"regularText\">" . $update_19;
	$html .= "</td><td><textarea class=\"textBox\" name=\"Description\" rows=\"7\" ";
	$html .= "cols=\"45\">" . $rows[Description] . "</textarea>";

	if(isset($description_error)){
		
		$html .= "<br /><font class=\"errorText\">" . $update_17 . $update_13;
		$html .= $spec[DescMin] . $update_14 . $spec[DescMax] . $update_15;
		$html .= "</font>";
	}
	
	$html .= "</td></tr><tr><td class=\"regularText\">" . $update_20 . "</td><td><select ";
	$html .= "class=\"textBox\" name=\"Category\">";
	
	drop_cats($rows[Category], 0, "", $cats);
	
	$html .= $cats;
	$html .= "</select></td></tr><tr><td class=\"regularText\">" . $update_21;
	$html .= "</td><td><select class=\"textBox\" name=\"Country\">";
			
	if($d = dir("images/flags")){
		
		$html .= getFlagList("images/flags", $rows[Country]);
	}
			
	$html .= "</select>";

	if(isset($country_error)){
		
		$html .= "<br /><font class=\"errorText\">" . $update_22 . "</font>";
	}
	
	$html .= "</td></tr><tr><td class=\"regularText\">" . $update_23 . "</td><td><input ";
	$html .= "class=\"textBox\" type=\"text\" name=\"UserName\" size=\"16\" value=\"";
	$html .= $rows[UserName] . "\" />";
	
	if(isset($user_name_error)){
		
		$html .= "<br /><font class=\"errorText\">" . $update_24 . $update_13;
		$html .= $spec[UserNameMin] . $update_14 . $spec[UserNameMax];
		$html .= $update_15 . "</font>";
	}
	
	$html .= "</td></tr><tr><td class=\"regularText\">" . $update_25 . "<br /><font ";
	$html .= "size=\"-1\">" . $update_26 . "</font></td><td><input class=\"textBox\" ";
	$html .= "type=\"password\" name=\"Password\" size=\"16\" value=\"";
	
	if(isset($Password) && !isset($validate_login)){
		
		$html .= $Password;
	}
	
	$html .= "\" />";
			
	if(isset($password_error)){
		
		$html .= "<br /><font class=\"errorText\">" . $update_28;
		$html .= $update_13 . $spec[PWMin] . $update_14 . $spec[PWMax];
		$html .= $update_15 . "</font>";
	}
	
	$html .= "</td></tr><tr><td class=\"regularText\">" . $update_29;
	$html .= "</td><td><input class=\"textBox\" type=\"password\" ";
	$html .= "name=\"Password2\" size=\"16\" value=\"";
		
	if(isset($Password2)){
		$html .= $Password2;
	}
		
	$html .= "\" />";

	if(isset($password2_error)){
		
		$html .= "<br /><font class=\"errorText\">" . $update_30 . "</font>";
	}
	
	$html .= "</td></tr><tr><td class=\"regularText\">" . $update_31;
	$html .= "</td><td><input class=\"textBox\" type=\"text\" name=\"Hint\" ";
	$html .= "size=\"35\" value=\"" . $rows[Hint] . "\" />";
			
	if(isset($hint_error)){
		
		$html .= "<br /><font class=\"errorText\">" . $update_32;
		$html .= $update_13 . $spec[HintMin] . $update_14 . $spec[HintMax];
		$html .= $update_15 . "</font>";
	}
	
	$html .= "</td></tr><tr><td class=\"regularText\">" . $update_39;
	$html .= "</td><td><input class=\"textBox\" type=\"text\" name=\"Email\" ";
	$html .= "size=\"35\" value=\"" . $rows[Email] . "\" />";

	if(isset($email_error)){
		
		$html .= "<br /><font class=\"errorText\">" . $update_33 . "</font>";
	}

	$html .= "</td></tr><tr><td colspan=\"2\" align=\"center\"><input ";
	$html .= "type=\"submit\" name=\"update_link\" value=\"" . $update_34;
	$html .= "\" /></td></tr></table></form>";
}

if(isset($html)){
	
	$final_html .= table("100%","center","",$html);
	unset($html);
}

if(
	(
		!session_is_registered("LinkID") || 
		isset($validate_login_error)) && 
		!isset($finished_update)
	){
	
	$html = "<br />" . $form_table . "<tr><form method=post action=\"index.php?";
	$html .= session_name() . "=" . session_id() . "&amp;show=update&amp;ID=";
	$html .= $ID . "\"><td class=\"regularText\" colspan=\"2\"><b>" . $update_35;
	$html .= "</b></td></tr><tr><td class=\"regularText\">" . $update_36;
	$html .= "</td><td><input class=\"textBox\" type=\"text\" name=\"UserName\" ";
	$html .= "size=\"16\" value=\"" . $UserName . "\" maxlength=\"16\" /></td></tr>";
	$html .= "<tr><td class=\"regularText\">" . $update_37 . "</td><td><input ";
	$html .= "class=\"textBox\" type=\"password\" name=\"Password\" size=\"16\" ";
	$html .= "value=\"" . $Password . "\" maxlength=\"16\" /></td></tr><tr><td ";
	$html .= "colspan=\"2\" align=\"center\"><input type=\"submit\" ";
	$html .= "name=\"validate_login\" value=\"" . $update_38 . "\" /></td>";
	$html .= "</form></tr></table><br />";
}

if(isset($html)){
	
	$final_html .= table("100%","center","",$html);
	unset($html);
}

echo $final_html;

?>
