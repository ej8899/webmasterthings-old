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
	$eligable=mysql_query("select id from wt_banneruser where approved='1' and credits >= 1 and id != '$uid'");
	$get_number=mysql_num_rows($eligable);
	if($get_number == 0){
		$eligable=mysql_query("select id from wt_banneruser where defaultacct='1' and id != '$uid'");
		}else{
	}
	while($rand_rows = mysql_fetch_array($eligable)){
				$id_array[] = $rand_rows[id];
			}
			srand((double)microtime()*1000000); 
			shuffle($id_array);
			srand((double)microtime()*1000000); 
			shuffle($id_array);
			$pick = $id_array[0];
			$get_banner = mysql_query("select bannerurl from wt_bannerurls where uid='$pick'");
			while($rand_ban = mysql_fetch_array($get_banner)){
				$ban_array[] = $rand_ban[bannerurl];
			}
			srand((double)microtime()*1000000); 
			shuffle($ban_array);
			srand((double)microtime()*1000000); 
			shuffle($ban_array);
		
	$banner=$ban_array[0];
	$cookieuid=$HTTP_COOKIE_VARS[cookieuid];
	$ip = getenv ("REMOTE_ADDR");
	$raw_query=mysql_query("select raw,lastip from wt_banneruser where id=$pick");
	$get_raw=mysql_fetch_array($raw_query);
	$rawcode=$get_raw[raw];
	if($rawcode != ''){
	$time = mktime()+$cookie_expire;
	$date = date("l, d-M-y H:i:s", ($time));
		if($cookieuid != $uid){
	header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
	setcookie("cookieuid",$uid, time()+$cookie_expire);
	echo "$rawcode";
				$update_id=mysql_query("update wt_banneruser set credits=credits+1,lastip='$ip' where id=$uid");
				$update_bid=mysql_query("update wt_banneruser set exposures=exposures+1, credits=credits-1 where id=$pick");
			}else{
			echo "$rawcode";
			$update_bid=mysql_query("update wt_banneruser set exposures=exposures+1, credits=credits-1 where id=$pick");
			}
	}else{
			if($cookieuid != $uid){
		header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
		setcookie("cookieuid",$uid, time()+$cookie_expire);
?>
<a href="<? echo "$base_url"; ?>/click.php?uid=<? echo "$uid"; ?>&bid=<? echo "$pick"; ?>" target=_blank><img src="<? echo "$banner"; ?>" border=0 width=468 height=60></a>
<?
		$update_id=mysql_query("update wt_banneruser set credits=credits+1,lastip='$ip' where id=$uid");
		$update_bid=mysql_query("update wt_banneruser set exposures=exposures+1, credits=credits-1 where id=$pick");
	}else{
?>
<a href="<? echo "$base_url"; ?>/click.php?uid=<? echo "$uid"; ?>&bid=<? echo "$pick"; ?>" target=_blank><img src="<? echo "$banner"; ?>" border=0 width=<? echo "$banner_width"; ?> height=<? echo "$banner_height"; ?>></a> 
<?
	$update_bid=mysql_query("update wt_banneruser set exposures=exposures+1, credits=credits-1 where id=$pick");
		?>
<?
}
	}
		?>
