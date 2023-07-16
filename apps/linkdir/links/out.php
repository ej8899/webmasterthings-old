<?
// *******************************************************************
//  out.php
// *******************************************************************

include("./include/config.php");
include("./include/functions.php");

if(isset($ID)){

	$get_site = sql_query("
		select
			SiteURL,
			OutIP
		from
			$tb_links
		where
			ID='$ID'
	");

	$get_row = sql_fetch_array($get_site);
	$url = $get_row[SiteURL];
}

if($REMOTE_ADDR != $get_row[OutIP]){
	
	$result = sql_query("
		update
			$tb_links
		set
			HitsOut = HitsOut + 1,
			OutIP = '$REMOTE_ADDR',
			LastUpdate = LastUpdate
		where
			ID = '$ID'
	");
}

header("Location: $url");

?>
