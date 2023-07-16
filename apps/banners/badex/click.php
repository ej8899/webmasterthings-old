<?
/////////////////////////////////////////////////
//              phpBannerExchange              //
//              A Free Script by:              //
//                                             //
// darkrose - darkrose@internetunderground.com //
//       lazurus - lazurus@rustedgate.com      //
//                                             //
// Updates and future versons can be found at: //
// http://www.internetunderground.com/scripts/ //
//                                             //
// This script is covered under the GNU GPL.   //
//                                             //
// If you modify this script, please make your //
// code available to us! We are not programmers//
// by trade, so there's bound to be bugs and   //
// inefficient code, but we're trying!         //
/////////////////////////////////////////////////

include("config.php");
	$update_clicks-mysql_query("update wt_banneruser set clicks=clicks+1 where id='$bid'");
	$update_clickfrom=mysql_query("update wt_banneruser set siteclicks=siteclicks+1 where id='$uid'");
	$get_rows=mysql_query("select url from wt_banneruser where id='$bid'");
	$get_url=@mysql_fetch_array($get_rows);
	$clickurl=$get_url[url];

	header("Location: $clickurl");
?>
