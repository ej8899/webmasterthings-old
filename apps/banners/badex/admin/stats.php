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
    <center><b>LOGIN ERROR!</b><br><br>The information you entered was incorrect or not found in the database! Please <a href="../index.php">go back</a> and try again!<br><br><?echo "$admlogin"; echo"$admpass"; echo"$udblogin"; echo"$udbpass";?></center>
<? include("../footer.php");
}else {
?>
		<html><head><title><? echo"$exchange_name"; ?> - Overall Stats</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<br><br>
    <center><b>Overall Stats for <? echo "$exchange_name"; ?></b><br>
	<?
		 //let's get some stats
$uid=0;
$users = mysql_query("select id from banneruser where approved='1'");
$totusers=@mysql_num_rows($users);
$exposures = mysql_query("select sum(exposures) as exposure from banneruser");
$exp = @mysql_fetch_array($exposures);
$totexp = $exp[exposure]+0;
$banners = mysql_query("select id from bannerurls");
$totbanners=@mysql_num_rows($banners);
$pending = mysql_query("select id from banneruser where approved='0'");
$pendusers=@mysql_num_rows($pending);
?>
<table cellpadding="0" cellspacing="0" width="350" class="windowbg">
  <tr>
    <td width="75%"><B>Total Users</B></td>
    <td width="25%"><? echo"$totusers";?></td>
  </tr>
  <tr>
    <td width="75%"><B>Total Exposures</B></td>
    <td width="25%"><? echo"$totexp";?></td>
  </tr>
  <tr>
    <td width="75%"><B>Total Banners</B></td>
    <td width="25%"><? echo"$totbanners";?></td>
  </tr>
  <tr>
    <td width="75%"><B>Total Pending Accounts</B></td>
    <td width="25%"><? echo"$pendusers";?></td>
  </tr>
</table><br><br><form method="POST" action="listall.php">
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type="submit" value="List All Accounts"></form>

<br><form method="POST" action="addaccount.php">
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type="submit" value="Add a New Account"></form>

<TABLE>
<TR><TD>


<TABLE Align="left" class="windowbg">
<TR><TD>
<center><b>Pending Accounts</b><br>

<?
//let's get some pending accounts
$pending = mysql_query("select * from banneruser where approved='0' order by login asc");
	$found = 0;
	include("pending.class.php");
	if($found == 0){
		echo "<center><table width=\"100%\" height=\"100%\">
	<tr valign=\"middle\" align=\"center\">
			<td>There are no pending accounts.</td>
	</tr>
</table></center>";
	} else {
		  ?><?
echo "".$total_found." pending accounts found.</center>";
	}
	
?>

</TD></TR>
</tABLE>


<table border="0" cellpadding="0" cellspacing="0" width="354" class="windowbg">
<TR><TD colspan="2">
<center>
<br><br><b>Change Admin Password</b><BR><BR>
<form method="POST" action="changepw.php">
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
    <tr>
      <td width="150">New Password</td>
      <td width="249"><input type="password" name="newpass1" size="20"></td>
    </tr>
    <tr>
      <td width="150">Again</td>
      <td width="249"><input type="password" name="newpass2" size="20"></td>
    </tr>
    <tr>
      <td width="102">&nbsp;</td>
      <td width="249"><input type="submit" value="Change Password" name="B3"></td>
</form>
    </tr>

<TR><TD colspan="2">
<BR>
<CENTER><b>Add an Admin</b></CENTER><BR>

<form method="POST" action="addadmin.php">

<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
    <tr>
      <td width="150">Username</td>
      <td width="249"><input type="text" name="newuser" size="20"></td>
    </tr>
    <tr>
      <td width="150">Password</td>
      <td width="249"><input type="text" name="newpass" size="20"></td>
    </tr>
    <tr>
      <td width="102">&nbsp;</td>
      <td width="249"><input type="submit" value="Add Admin"></td>
    </tr>
  </table>

</TD></TR>
</TABLE>

</form>
</center>
<?
include("../footer.php");
}
?>