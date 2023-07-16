<?
// *******************************************************************
//  include/review_add.php
// *******************************************************************

$html = $table2 . "<tr><td class=\"whatText\">" . $review_add_24;
$html .= "</td></tr></table>";

echo whattable("100%","center","",$html);
unset($html);

$get = sql_query("
	select
		*
	from
		$tb_links
	where
		ID='$SiteID'
");

$get_rows = sql_fetch_array($get);

if(!isset($submit_review)){

	$html = $table2 . "<tr>";
	$html .= "<td class=\"regularText\" align=\"center\"><br />" . $review_add_23;
	$html .= " <a class=\"regularBoldText\" href=\"out";
	if($user_outer_frame == "Y"){$html .= "_frame";}
	$html .= ".php?" . session_name();
	$html .= "=" . session_id() . "&amp;ID=" . $get_rows[ID] . "\" ";
	$html .= "target=\"_";
	if($user_outer_frame == "Y"){$html .= "top";}else{$html .= "blank";}
	$html .= "\">" . $get_rows[SiteName] . "</a></td></tr></table><br />";
}

echo table("100%","center","",$html);
unset($html);

if(isset($submit_review)){
	unset($error);

	$get_specs = sql_query("
		select
			*
		from
			$tb_specs
		where
			ID='1'
	");

	$spec = sql_fetch_array($get_specs);

	if(strlen($ReviewTitle) > $spec["ReviewTitleMax"]){
		$error = 1;
		$review_title_error = 1;
	}

	if(strlen($ReviewTitle) < $spec["ReviewTitleMin"]){
		$error = 1;
		$review_title_error = 1;
	}

	if(strlen($Reviewer) > $spec["ReviewerMax"]){
		$error = 1;
		$reviewer_error = 1;
	}

	if(strlen($Reviewer) < $spec["ReviewerMin"]){
		$error = 1;
		$reviewer_error = 1;
	}

	if(strlen($Review) < $spec["ReviewMin"]){
		$error = 1;
		$review_error = 1;
	}

	if(strlen($Review) > $spec["ReviewMax"]){
		$error = 1;
		$review_error = 1;
	}

	if(!ereg($spec["ReviewerEmailSpec"], $ReviewerEmail)){
		$error = 1;
		$reviewer_email_error = 1;
	}

	if(!isset($error)){
		
		$insert = sql_query("
			insert into	$tb_reviews (
				ID,
				SiteID,
				ReviewTitle,
				Review,
				Reviewer,
				ReviewerEmail,
				ReviewerURL,
				Rating,
				Status,
				Added
			) values (
				'',
				'$SiteID',
				'$ReviewTitle',
				'$Review',
				'$Reviewer',
				'$ReviewerEmail',
				'$ReviewerURL',
				'$Rating',
				'New',
				now()
			)
		");

		$html = $table2 . "<tr><td class=\"regularText\"><br />" . $review_add_1;
		$html .= "<br /><br />" . $review_add_2 . stripslashes($ReviewTitle);
		$html .= "<br /><br />" . $review_add_3 . $Reviewer;
		$html .= "<br /><br />" . $review_add_4 . stripslashes($Review);
		$html .= "<br /><br />" . $review_add_5 . $Rating;
		$html .= "<br /><br />" . $review_add_6 . $ReviewerEmail;
		$html .= "<br /><br /></td></tr></table>";
	
	} else {
		
		$html = $table2 . "<tr>";
		$html .= "<td class=\"errorTextBold\" align=\"center\"><br />";
		$html .= $review_add_7 . "<br /><br /></td></tr></table>";
	}
}

echo table("98%","center","",$html);
unset($html);

if(!isset($submit_review) || isset($error)){

	$html = "<form method=\"post\" action=\"index.php?" . session_name() . "=";
	$html .= session_id() . "&amp;show=review_add&amp;SiteID=" . $SiteID;
	$html .= "\">" . $form_table . "<tr><td width=\"40%\" align=\"right\" ";
	$html .= "valign=\"top\" class=\"regularText\">" . $review_add_8;
	$html .= "</td><td width=\"60%\"><input class=\"textBox\" ";
	$html .= "type=\"text\" name=\"ReviewTitle\" maxlength=\"120\" size=\"35\" ";
	$html .= "value=\"" . $ReviewTitle . "\" />";
		
	if(isset($review_title_error)){
		$html .= "<br /><font class=\"errorText\">" . $review_add_9;
		$html .= $spec["ReviewTitleMin"] . $review_add_10 . $spec["ReviewTitleMax"];
		$html .= $review_add_11 . ".</font>";
	}

	$html .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$html .= "class=\"regularText\">" . $review_add_12 . "</td><td width=\"60%\">";
	$html .= "<input class=\"textBox\" type=\"text\" name=\"Reviewer\" size=\"35\" ";
	$html .= "value=\"" . $Reviewer . "\" />";

	if(isset($reviewer_error)){
		$html .= "<br /><font class=\"errorText\">" . $review_add_13;
		$html .= $spec["ReviewerMin"] . $review_add_10 . $spec["ReviewerMax"];
		$html .= $review_add_11 . ".</font>";
	}
	
	$html .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$html .= "class=\"regularText\">" . $review_add_15 . "</td><td width=\"60%\">";
	$html .= "<input class=\"textBox\" type=\"text\" name=\"ReviewerEmail\" ";
	$html .= "size=\"35\" value=\"" . $ReviewerEmail . "\" />";

	if(isset($reviewer_email_error)){
		$html .= "<br /><font class=\"errorText\">" . $review_add_14 . "</font>";
	}

	$html .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$html .= "class=\"regularText\">" . $review_add_16 . "</td><td width=\"60%\">";
	$html .= "<input class=\"textBox\" type=\"text\" name=\"ReviewerURL\" ";
	$html .= "size=\"35\" value=\"" . $ReviewerURL . "\" /></td></tr><tr><td ";
	$html .= "width=\"40%\" align=\"right\" valign=\"top\" class=\"regularText\">";
	$html .= $review_add_17 . "</td><td width=\"60%\"><textarea class=\"textBox\" ";
	$html .= "name=\"Review\" rows=\"10\" cols=\"45\">" . $Review . "</textarea>";

	if(isset($review_error)){
		$html .= "<br /><font class=\"errorText\">" . $review_add_18;
		$html .= $spec["ReviewMin"] . $review_add_10 . $spec["ReviewMax"];
		$html .= $review_add_11 . ".</font>";
	}

	$html .= "</td></tr><tr><td width=\"40%\" align=\"right\" valign=\"top\" ";
	$html .= "class=\"regularText\">" . $review_add_19 . "</td><td width=\"60%\" ";
	$html .= "class=\"regularText\"><select class=\"textBox\" name=\"Rating\">";

	for($x=10;$x>0;$x--){
		
		$html .= "<option value=\"" . $x . "\"";

		if(isset($Rating)){
				
			if($x==$Rating){$html .= " selected=\"selected\"";}

		} else {
				
			if($x==5){$html .= " selected=\"selected\"";	}

		}
			
		$html .= ">" . $x . "</option>";
	}

	$html .= "</select>&nbsp;&nbsp;(1=" . $review_add_20 . "&nbsp;&nbsp;10=";
	$html .= $review_add_21 . ")</td></tr><tr><td width=\"100%\" colspan=\"2\" ";
	$html .= "align=\"center\"><br /><input type=\"submit\" name=\"submit_review\" ";
	$html .= "value=\"" . $review_add_22 . "\" /></td></tr></table></form>";
}

echo table("100%","center","",$html);
unset($html);

?>
