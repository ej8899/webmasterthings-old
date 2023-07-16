<?
// *******************************************************************
//  out_frame.php
// *******************************************************************

include("include/config.php");
include("include/functions.php");
include("include/common.php");
$language = $gl["Language"];
include("include/lang/$language.php");
include("include/session.php");
// tcm remove php warning
// session_start();

if(isset($ID)){

	$get_site = sql_query("
		select
			SiteURL,
			OutIP
		from
			$tb_links
		where
			ID = '$ID'
	");

	$get_row = sql_fetch_array($get_site);
	$url = $get_row["SiteURL"];
}

if($REMOTE_ADDR != $get_row["OutIP"]){
	
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"DTD/xhtml1-frameset.dtd">
<html>
	<head>
		<title>phpLinks - Outer Frame - </title>
	</head>
	<frameset border="0" frameborder="0" rows="100,*">
		<frame name="top" src="top_frame.php?<?=session_name()?>=<?=session_id()?>" scrolling="no" marginwidth="10" marginheight="5" topmargin="5" leftmargin="10" />
		<frame name="main" src="<?=$url?>" scrolling="auto" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" />
	</frameset>
</html>
