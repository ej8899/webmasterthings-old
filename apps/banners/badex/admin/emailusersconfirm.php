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
 $result = mysql_query("select * from banneradmin where adminuser='$admlogin' AND adminpass='$admpass'");
$get_userinfo=@mysql_fetch_array($result);
$id=$get_userinfo[id];
$admlogin=$get_userinfo[adminuser];
$admpass=$get_userinfo[adminpass];
    if($admlogin=="" AND $admpass=="" OR $admpass=="") {
?><html><head><title><? echo"$exchange_name"; ?> - LOGIN ERROR!</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body>
<p>&nbsp;
    <center><b>LOGIN ERROR!</b><p>The information you entered was incorrect or not found in the database! Please <a href="../index.php">go back</a> and try again!<p><?echo "$login"; echo"$pass"; echo"$udblogin"; echo"$udbpass";?></center>
<? include("../footer.php");
}else {
?>
		<html><head><title><? echo"$exchange_name"; ?> - Delete Banner</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<p>
	<?
	$delete=mysql_query("delete from bannerurls where id=$bannerid");
?>
<center>The Banner has been deleted! <form action=edit.php method=post>
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type="submit" value="Back to Edit Account">
</form>
<? include("../footer.php"); ?>
	<?
	}
	?>