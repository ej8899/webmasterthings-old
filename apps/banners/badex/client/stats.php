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
		<html><head><title><? echo"$exchange_name"; ?> - Stats</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<br><br>
    <center><h2>Stats for <? echo "$login"; ?></h2><br><br>
	<?
	 //let's get some stats
$stats=mysql_query("select * from banneruser where login='$login'");
$get_stats=mysql_fetch_array($stats);
$url=$get_stats[url];
$exposures=$get_stats[exposures];
$credits=$get_stats[credits];
$clicks=$get_stats[clicks];
$siteclicks=$get_stats[siteclicks];
$approved=$get_stats[approved];
$uid=$get_stats[id];
?>
<table cellpadding="0" cellspacing="0" width="350" class="windowbg">
  <tr>
    <td width="75%"><B>Exposures</B></td>
    <td width="25%"><? echo"$exposures";?></td>
  </tr>
  <tr>
    <td width="75%"><B>Credits</B></td>
    <td width="25%"><? echo"$credits";?></td>
  </tr>
  <tr>
    <td width="75%"><B>Clicks From Your Site</B></td>
    <td width="25%"><? echo"$siteclicks";?></td>
  </tr>
  <tr>
    <td width="75%"><B>Clicks On Your Banner</B></td>
    <td width="25%"><? echo"$clicks";?></td>
  </tr>
</table><br><br>
<?
if($approved==0){
	echo "<B>Your account has not yet been approved by the admin. This means your banners will not be in the rotation, however you will still get credits for exposures of member banners on your site.</B></p></center>";
}else{
	echo"<B>Your account is currently approved and in the regular rotation</B></p></center>";
}
?><center><table cellpadding="4" cellspacing="4" width="500" class="windowbg">
  <tr>
    <td width="44%" colspan="2">
    <CENTER><B>Your Active Banners</B></CENTER></td>
  </tr><?

//let's get some banners
$banners = mysql_query("select * from bannerurls where uid='$uid'");
	$found = 0;
	include("banner.class.php");
	if($found == 0){
		echo "</tr></table><h3>No Banners Found for your account!</h3></center>";
	} else {
		  ?> </tr>
</table><?
echo "".$total_found." banners found.</center>";
	}
?>
<center><form method="POST" action="addbanner.php">
<table cellpadding="0" cellspacing="0" width="300">
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=login value=<? echo "$udblogin"; ?>>
<input type=hidden name=pass value=<? echo "$udbpass"; ?>>
    <tr>
      <td width="100%" colspan="2">
      <p align="center">Add a Banner</td>
    </tr>
    <tr>
      <td width="84%"><CENTER>
		<input type="text" name="bannerurl" size="40" value="http://"><BR>
			<input type="submit" value="  Add it!  ">
			</CENTER></td>
    </tr>
  </table>
</form></center>
<br><br><center><form method="POST" action="changeurl.php">
<table cellpadding="0" cellspacing="0" width="300">
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=login value=<? echo "$udblogin"; ?>>
<input type=hidden name=pass value=<? echo "$udbpass"; ?>>
    <tr>
      <td width="100%" colspan="2">
      <p align="center">Modify Target URL</td>
    </tr>
    <tr>
      <td width="84%"><CENTER>
		<input type="text" name="newurl" value="<? echo "$url"; ?>" size="40">
		<BR>
		<input type="submit" value="Change">
		</CENTER></td>
    </tr>
  </table>
</form>
<TABLE CLASS="windowbg">
<TR><TD><CENTER><BR><B>Other Options</B><BR><BR>

<form method="POST" action="info.php">
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=login value=<? echo "$udblogin"; ?>>
<input type=hidden name=pass value=<? echo "$udbpass"; ?>>
<input type="submit" value="Change User Info"></form>
<form method="POST" action="gethtml.php">
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=login value=<? echo "$udblogin"; ?>>
<input type=hidden name=pass value=<? echo "$udbpass"; ?>>
<input type="submit" value="Get HTML Code"></form>
<form method="POST" action="emailstats.php">
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=login value=<? echo "$udblogin"; ?>>
<input type=hidden name=pass value=<? echo "$udbpass"; ?>>
<input type="submit" value="Email Stats"></form>
<form method="POST" action="logout.php">
<input type="submit" value="LOG OUT"></form>

</CENTER></TD></TR>
</tABLE>

</center>
<br><br>&nbsp;
	<? include("../footer.php");
}
?>