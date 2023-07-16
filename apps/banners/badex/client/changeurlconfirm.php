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

include("../config.php");
 $result = mysql_query("select * from banneruser where login='$login' AND pass='$pass'");
$get_userinfo=@mysql_fetch_array($result);
$uid=$get_userinfo[id];
$udblogin=$get_userinfo[login];
$udbpass=$get_userinfo[pass];
    if($udblogin=="" AND $udbpass=="" OR $udbpass=="") {
?><html><head><title><? echo"$exchange_name"; ?> - LOGIN ERROR!</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body>
<br><br>&nbsp;
    <center><b>LOGIN ERROR!</b><br><br>The information you entered was incorrect or not found in the database! Please <a href="../index.php">go back</a> and try again!<br><br>
<? include("../footer.php");
}else {
?>
		<html><head><title><? echo"$exchange_name"; ?> - Change URL</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<br><br>
<?
	$update=mysql_query("update banneruser set url='$newurl' where id='$uid'");
?>
<center>Your URL has been changed! <form action=stats.php method=post>
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=login value=<? echo "$login"; ?>>
<input type=hidden name=pass value=<? echo "$pass"; ?>>
<input type="submit" value="Back to Stats">
</form>
<? include("../footer.php"); ?>
	<?
	}
	?>