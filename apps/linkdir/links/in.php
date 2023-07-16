<?
// *******************************************************************
//  in.php
// *******************************************************************
include("./include/config.php");
include("./include/functions.php");
include("./include/session.php");
// tcm remove php warning
// session_start();
if(isset($ID)){
	$get_site = sql_query("
		select
			*
		from
			$tb_links
		where
			ID='$ID'
	");
	
	$get_row = sql_fetch_array($get_site);
}
if($REMOTE_ADDR != $get_row[InIP]){
	$result = sql_query("
		update
			$tb_links
		set
			HitsIn = HitsIn + 1,
			InIP = '$REMOTE_ADDR',
			LastUpdate = LastUpdate
		where
			ID='$ID'
	");
}
$index = "./index.php?" . session_name() . "=" . session_id();
header("Location: $index");
?>