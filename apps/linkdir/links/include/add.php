<?
// *******************************************************************
//  include/add.php
// *******************************************************************

$htmlsrc = $table2 . "<tr>\r\n\t<td class=\"whatText\">";
$htmlsrc .= $add_1 . "</td>\r\n</tr>\r\n</table>\r\n";

echo whattable("100%","center","",$htmlsrc);
unset($htmlsrc);

// Handle form submission
if(isset($submit_add)){

////////////////////////////////////////////////////////////////////////////////////////
// PHPLinks Critical XSS Vulnerability Fix - By JeiAr - jeiar@kmfms.com //
///////////////////////////////////////////////////////////////////////////////////////
	$ip = $REMOTE_ADDR;
	$info = $HTTP_USER_AGENT;
	if (ereg('[-!#$%\'"*+\\.<->=?^_`{|}]$', $SiteName)) {$err.= "Please enter 
	A valid Site Name.<BR>";}    
	if (ereg('[-!#$%&\'"*+.<->=?^_`{|}]$', $SiteURL)) {$err.= "Please enter 
	A valid Site URL.<BR>";}
	if (ereg('[-!#$%&\'"*+\\.<->=?^_`{|}]$', $Description)) {$err.= "Enter A 
	valid Description.<BR>";}    
	if (ereg('[-!#$%&\'"*+\\.<->=?^_`{|}]$', $Category)) {$err.= "Enter A 
	valid Category.<BR>";}
	if (ereg('[-!#$%&\'"*+\\.<->=?^_`{|}]$', $Country)) {$err.= "Enter A valid 
	Country.<BR>";}    
	if (ereg('[-!#$%&\'"*+\\.<->=?^_`{|}]$', $UserName)) {$err.= "Enter A 
	valid UserName.<BR>";}
	if (ereg('[-!#$%&\'"*+\\.<->=?^_`{|}]$', $PW)) {$err.= "Please enter A 
	valid Password.<BR>";}    
	if (ereg('[-!#$%&\'"*+\\.<->=?^_`{|}]$', $PW2)) {$err.= "Please enter A 
	valid Password.<BR>";}
	if (ereg('[-!#$%&\'"*+\\.<->=?^_`{|}]$', $Hint)) {$err.= "Please enter A 
	valid Hint.<BR>";}    
	if ($err) {
	echo $err;
	echo "<b>Possible Hack Attempt!!</b><br>";
	echo "<b>$ip</b><br>";
	echo "<b>$info</b><br>";
	echo "<a href=index.php?show=add>Back</a>";
	exit;
	}
///////////////////////////////////////////////////////////////////////////////////////////
	
	// Get current admin specs for adding new files
	$get_specs = sql_query("
		select
			*
		from
			$tb_specs
		where
			ID='1'
	");
	
	// Initialize $spec array
	$spec = sql_fetch_array($get_specs);
	
	unset($error);
	
	// Check for errors on submission
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

	$url = @parse_url($SiteURL);
	$concat_url = $url[host] . $url[path];
	
	if(strlen($concat_url)>4){
		
		$check_url_links = sql_query("
			select
				*
			from
				$tb_links
			where
				SiteURL
			like
				'%$concat_url%'
		");

		if(sql_num_rows($check_url_links)>0){
			
			$error = 1; $duplicate_links_error = 1;
			$rows = sql_fetch_array($check_url_links);
			$ID = $rows[ID];
		}

		$check_url_temp = sql_query("
			select
				*
			from
				$tb_temp
			where
				SiteURL
			like
				'%$concat_url%'
		");

		if(sql_num_rows($check_url_temp)>0){
		
			$error = 1;
			$duplicate_temp_error = 1;
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

	if(strlen($PW) < $spec[PWMin]){
		$error = 1;
		$password_error = 1;
	}

	if(strlen($PW) > $spec[PWMax]){
		$error = 1;
		$password_error = 1;
	}

	if($PW != $PW2){
		$error = 1;
		$password2_error = 1;
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

		if($validate == "N"){
			
			$insert_table = $tb_links;
		} else {
			
			$insert_table = $tb_temp;
		}

		$insert = sql_query("
			insert into $insert_table(
				ID,
				SiteName,
				SiteURL,
				LastUpdate,
				Added,
				Description,
				Category,
				Country,
				UserName,
				Password,
				Hint,
				Email
			) values (
				'',
				'$SiteName',
				'$SiteURL',
				now()+0,
				now()+0,
				'$Description',
				'$Category',
				'$Country',
				'$UserName',
				password('$PW'),
				'$Hint',
				'$Email'
			)
		");

		if($validate == "N"){
			$id = sql_insert_id();
		}

		$htmlsrc = $main_table . "<tr>\r\n\t";
		$htmlsrc .= "<td class=\"regularBoldText\">" . $add_2 . "</td>\r\n";
		$htmlsrc .= "</tr>\r\n";
		$htmlsrc .= "<tr>\r\n\t<td class=\"regularText\">" . $add_3;
		$htmlsrc .= stripslashes($SiteName) . "<br /><br />" . $add_4 . $SiteURL;
		$htmlsrc .= "<br /><br />" . $add_5 . stripslashes($Description);
		$htmlsrc .= "<br /><br />" . $add_6;

		$gc = sql_query("
			select
				Category
			from
				$tb_categories
			where
				ID='$Category'
		");

		$fa = sql_fetch_array($gc);
			
		$Country = eregi_replace("_"," ",$Country);
		$Country = eregi_replace(".gif","",$Country);
		$Country = eregi_replace(".png","",$Country);	

		$htmlsrc .= $fa[Category] . "<br /><br />" . $add_46 . $Country;
		$htmlsrc .= "<br /><br />" . $add_7 . $UserName;
		$htmlsrc .= "<br /><br />" . $add_8 . $Hint . "<br /><br />" . $add_9;
		$htmlsrc .= $Email . "<br /><br />";

		if($validate == "N"){
			
			$sn = stripslashes($SiteName);
			
			$htmlsrc .= $add_10 . "<form><textarea class=\"textBox\" ";
			$htmlsrc .= "name=\"name\" rows=\"4\" cols=\"45\" readonly";
			$htmlsrc .= "><a href=\"" . $base_url . "/in.php?ID=" . $id;
			$htmlsrc .= "\" target=\"_blank\">" . $site_title . "</a><br /><br />";
			$htmlsrc .= "</textarea></form>" . $add_11 . "<br /><br />";
			$htmlsrc .= $add_12 . $sn . ".";
			$htmlsrc .= "<form><textarea class=\"textBox\" name=\"name\" ";
			$htmlsrc .= "rows=\"4\" cols=\"45\" readonly>";
			$htmlsrc .= "<a href=\"" . $base_url . "/index.php?show=review_add&amp;SiteID=";
			$htmlsrc .= $id . "\" target=\"_blank\">" . $add_13;
			$htmlsrc .= $sn . "</a><br /><br /></textarea></form>";
		
		} else {
			
			$htmlsrc .= $add_14;
		}

		$htmlsrc .= "<br /></td></tr></table>";

		if(($email_addition == "Y") && ($validate == "Y")){
			
			include("include/email_addition.php");
		}

	} else {
		
		$htmlsrc .= $table2 . "<tr>";
		$htmlsrc .= "<td class=\"errorTextBold\" align=\"center\">" . $add_15;
		$htmlsrc .= "</td></tr></table>";
	}
}

echo table("100%","center","",$htmlsrc);
unset($htmlsrc);

if(!isset($submit_add) || isset($error)){

	$htmlsrc = "<form method=\"post\" action=\"index.php?" . session_name();
	$htmlsrc .= "=" . session_id() . "&amp;show=add\">" . $form_table . "<tr>";
	$htmlsrc .= "\r\n\t<td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_16;
	$htmlsrc .= "</td>\r\n\t<td width=\"60%\" class=\"pagenav\">";
	$htmlsrc .= "<input class=\"textBox\" type=\"text\" name=\"SiteName\" ";
	$htmlsrc .= "maxlength=\"120\" size=\"35\" value=\"" . $SiteName . "\" />";

	if(isset($site_name_error)){

		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_17 . $spec[SiteNameMin];
		$htmlsrc .= $add_18 . $spec[SiteNameMax] . $add_19 . ".</font>";
	}

	$htmlsrc .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_20 . "</td><td width=\"60%\" ";
	$htmlsrc .= "class=\"pagenav\"><input class=\"textBox\" type=\"text\" name=\"SiteURL\" ";
	$htmlsrc .= "maxlength=\"100\" size=\"35\" value=\"";

	
	if(isset($SiteURL) && strlen($SiteURL)>0){		
		$htmlsrc .= $SiteURL;
	} else {	
		$htmlsrc .= "http://";
	}

	$htmlsrc .= "\" />";

	if(isset($site_url_error)){
		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_21 . ".</font>";
	}

	if(isset($duplicate_links_error)){

		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_22;
		$htmlsrc .= "<a href=\"index.php?" . session_name() . "=" . session_id();
		$htmlsrc .= "&amp;show=update&amp;ID=" . $ID . "\">" . $add_23;
		$htmlsrc .= "</a>.</font>";
	}

	if(isset($duplicate_temp_error)){
		echo "<br /><font class=\"errorText\">" . $add_24 . ".</font>";
	}

	$htmlsrc .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_25 . "</td><td width=\"60%\" ";
	$htmlsrc .= "class=\"pagenav\"><textarea class=\"textBox\" name=\"Description\" ";
	$htmlsrc .= "rows=\"7\" cols=\"40\">" . $Description;
	$htmlsrc .= "</textarea>";

	if(isset($description_error)){
		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_26 . $spec[DescMin];
		$htmlsrc .= $add_18 . $spec[DescMax] . $add_28 . ".</font>";
	}

	$htmlsrc .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_29 . "</td><td width=\"60%\" ";
	$htmlsrc .= "class=\"pagenav\"><select class=\"textBox\" name=\"Category\">";

	if(isset($Category)){
		$PID = $Category;
	}

	if(!isset($PID) && !isset($Category)){
		$PID = 0;
	}
	
	$htmlsrc .= drop_cats($PID, 0, "", $cats);
	$htmlsrc .= $cats;

	$htmlsrc .= "</select></td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_46 . "</td><td width=\"60%\" ";
	$htmlsrc .= "class=\"pagenav\"><select class=\"textBox\" name=\"Country\"><option ";
	$htmlsrc .= "value=\"\">" . $add_47 . "</option>";

	if(!isset($Country)){
		$Country = $default_country;
	}

	if($d = dir("./images/flags")){
		$htmlsrc .= getFlagList("./images/flags", $Country);
	}

	$htmlsrc .= "</select>";

	if(isset($country_error)){
		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_48 . "</font>";
	}

	$htmlsrc .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_30 . "</td><td width=\"60%\" ";
	$htmlsrc .= "class=\"pagenav\"><input class=\"textBox\" type=\"text\" ";
	$htmlsrc .= "name=\"UserName\" maxlength=\"16\" value=\"" . $UserName . "\" />";
	
	if(isset($user_name_error)){
		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_31 . $spec[UserNameMin];
		$htmlsrc .= $add_18 . $spec[UserNameMax] . $add_33 . "</font>";
	}

	$htmlsrc .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_34 . "</td><td width=\"60%\" ";
	$htmlsrc .= "class=\"pagenav\"><input class=\"textBox\" type=\"password\" ";
	$htmlsrc .= "name=\"PW\" maxlength=\"16\" value=\"" . $PW . "\" />";

	if(isset($password_error)){
		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_35 . $spec[PWMin];
		$htmlsrc .= $add_18 . $spec[PWMax] . $add_37 . "</font>";
	}

	$htmlsrc .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_38 . "</td><td width=\"60%\" ";
	$htmlsrc .= "class=\"pagenav\"><input class=\"textBox\" type=\"password\" ";
	$htmlsrc .= "name=\"PW2\" maxlength=\"16\" value=\"" . $PW2 . "\" />";

	if(isset($password2_error)){
		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_39 . ".</font>";
	}

	$htmlsrc .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_40 . "</td><td width=\"60%\" ";
	$htmlsrc .= "class=\"pagenav\"><input class=\"textBox\" type=\"text\" ";
	$htmlsrc .= "name=\"Hint\" maxlength=\"50\" value=\"" . $Hint . "\" />";

	if(isset($hint_error)){
		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_41 . $spec[HintMin];
		$htmlsrc .= $add_18 . $spec[HintMax] . $add_42 . ".</font>";
	}

	$htmlsrc .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$htmlsrc .= "class=\"regularText\">" . $add_43 . "</td><td width=\"60%\" ";
	$htmlsrc .= "class=\"pagenav\"><input class=\"textBox\" type=\"text\" ";
	$htmlsrc .= "name=\"Email\" maxlength=\"50\" value=\"" . $Email . "\" />";

	if(isset($email_error)){
		$htmlsrc .= "<br /><font class=\"errorText\">" . $add_44 . ".</font>";
	}

	$htmlsrc .= "</td></tr><tr><td width=\"100%\" colspan=\"2\" align=\"center\">";
	$htmlsrc .= "<br /><input type=\"submit\" name=\"submit_add\" value=\"" . $add_45;
	$htmlsrc .= "\" /></td></tr></table></form>";

	echo table("100%","center","",$htmlsrc);
	unset($htmlsrc);
}

?>
