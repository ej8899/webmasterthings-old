<?
// *******************************************************************
//  include/review.php
// *******************************************************************

$html = $table2 . "<tr><td class=\"whatText\">" . $review_1;
$html .= "</td></tr></table>";

echo whattable("100%","center","",$html);
unset($html);

$get_site = sql_query("
	select
		*
	from
		$tb_links
	where
		ID = '$SiteID'
");

$site_rows = sql_fetch_array($get_site);

$average = sql_query("
	select
		avg(Rating) as average
	from
		$tb_reviews
	where
		SiteID = '$SiteID'
	and
		Status = 'Show'
");

$av_rows = sql_fetch_array($average);

$html = $table2 . "<tr><td class=\"regularText\"><font class=\"regularText\">";
$html .= $review_2 . "</font> <a class=\"regularBoldText\" href=\"out";
if($user_outer_frame == "Y"){$html .= "_frame";}
$html .= ".php?";
$html .= session_name() . "=" . session_id() . "&amp;ID=";
$html .= $site_rows["ID"] . "\" target=\"_";
if($user_outer_frame == "Y"){$html .= "top";}else{$html .= "blank";}
$html .= "\">" . $site_rows["SiteName"] . "</a>";

if(isset($av_rows["average"])){
	
	$html .= " - " . $review_3 . "<font class=\"regularBoldText\">";
	$html .= $av_rows["average"] . "</font>";
}

$html .= "</td></tr>";

$get_reviews = sql_query("
	select
		*
	from
		$tb_reviews
	where
		SiteID='$SiteID'
	and
		Status='Show'
	order by
		Added desc
	limit
		0,10
");

if(sql_num_rows($get_reviews)>0){
	
	$html .= "<tr><td class=\"regularText\"><br /><ul>";

	while($rows = sql_fetch_array($get_reviews)){

		$html .= "<li><font class=\"regularBoldText\">" . $rows[ReviewTitle];
		$html .= "</font> - " . $rows[Review] . "<br />" . $review_4;
		$html .= $rows[Reviewer] . " - &lt;";

		$secure_email = str_replace("@", $review_5, $rows[ReviewerEmail]);
		$secure_email = str_replace(".", $review_6, $secure_email);
		$secure_email = str_replace("-", $review_7, $secure_email);
		$secure_email = str_replace("_", $review_8, $secure_email);

		$html .= $secure_email . "&gt;";

		if(strlen($rows[ReviewerURL])>0){
			$html .= " of <a class=\"regularText\" href=\"" . $rows[ReviewerURL];
			$html .= "\" target=\"_blank\">" . $rows[ReviewerURL] . "</a>";
		}

		$html .= "</li>";

	}

	$html .= "</ul></td></tr></table>";

} else {

	$html = $table2 . "<tr><td class=\"regularText\">" . $review_9;
	$html .= "<br /><br /></td></tr></table>";
}

echo table("98%","center","",$html);
unset($html);

$html = $table2 . "<tr><td class=\"regularText\"><a class=\"regularText\" ";
$html .= "href=\"index.php?" . session_name() . "=" . session_id();
$html .= "&amp;show=review_add&amp;SiteID=" . $SiteID . "\">" . $review_10;
$html .= "</a></td></tr></table>";

echo table("98%","center","",$html);
unset($html);

?>

