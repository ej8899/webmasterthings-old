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
<br><br>&nbsp;
    <center><b>LOGIN ERROR!</b><br><br>The information you entered was incorrect or not found in the database! Please <a href="../index.php">go back</a> and try again!<br><br><?echo "$login"; echo"$pass"; echo"$udblogin"; echo"$udbpass";?></center>
<? include("../footer.php");
}else {
?>
		<html><head><title><? echo"$exchange_name"; ?> - List All Accounts</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<br><br>
    <center><b><? echo "$exchange_name"; ?> - Listing All Accounts</b><br><br>
	<form method="POST" action="stats.php">
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type="submit" value="Back to Stats"><BR><BR>
</form>
<br><br>
Default Accounts
<TABLE width="400" Class="windowbg">
<TR><TD>
<CENTER>
<BR>
<?
//let's list all the accounts
$pending = mysql_query("select * from banneruser where approved='1' and defaultacct='1' order by login asc");
	$found = 0;
	include("pending.class.php");
	if($found == 0){
		echo "<center>There are no Default Accounts set up. You should set up at least ONE account as a default account.</center>";
	} else {
		  ?> </tr>
</table><?
echo "".$total_found." default accounts found.</center>";
	}
		?>
</cENTER>
</TD></TR>
</TABLE><center>
<br><br>Normal Active Accounts:
<TABLE width="400" Class="windowbg">
<TR><TD>
<CENTER>
<BR>
<?
//let's list all the accounts
$pending = mysql_query("select * from banneruser where approved='1' and defaultacct='0' order by login asc");
	$found = 0;
	include("pending.class.php");
	if($found == 0){
		echo "<center>There are no normal accounts found!! (why are you looking here?!!)</center>";
	} else {
		  ?> </tr>
</table><?
echo "".$total_found." normal accounts found.</center>";
	}
		?>
</cENTER>
</TD></TR>
</TABLE>
<form method="POST" action="stats.php">
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<CENTER><input type="submit" value="Back to Stats"></CENTER>
</form>
<br><br></center>
<? include("../footer.php"); ?>
	<?
	}
	?>