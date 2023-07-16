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
		<html><head><title><? echo"$exchange_name"; ?> - Email Users</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<p>
    <center><b><? echo "$exchange_name"; ?> - Email Users</b><br><br>
<form method="POST" action="emailuserspreview.php">
<table border="0" cellpadding="0" cellspacing="0" width="80%">
    <tr>
      <td width="50%">To:</td>
      <td width="50%"><select size="1" name="to"></select></td>
    </tr>
    <tr>
      <td width="50%">Subject:</td>
      <td width="50%"><input type="text" name="subject" size="40"></td>
    </tr>
    <tr>
      <td width="50%">Message:</td>
      <td width="50%"><textarea rows="5" name="message" cols="40"></textarea></td>
    </tr>
  </table>
  <p><input type="submit" value="Submit"><input type="reset" value="Reset"></p>
</form>

<? include("../footer.php"); ?>
	<?
	}
	?>