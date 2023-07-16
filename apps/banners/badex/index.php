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
?>
<html><head><title><? echo "$exchange_name"; ?> - Control Panel Login</title><LINK REL=stylesheet HREF="style.css" TYPE="text/css">
</head>
<body>
<p>
    <center>

	<h3>Welcome to <? echo "$exchange_name"; ?>.</h3><BR><BR>

    <table width="200" cellpadding="0" cellspacing="1" border="0" bgcolor="#333333" class="windowbg"><tr><td>
    <center><TABLE width="100%"><TR><TD BGCOLOR="#222222"><CENTER><B>Banner Exchange<BR>Control Panel</B></CENTER></TD></TR></TABLE></center>
    <table width="100%" cellpadding="5" cellspacing="1" border="0" bgcolor="#000000"><tr>
    </td></tr><tr><td><center>
    <form action="<?echo"$base_url"?>/client/stats.php" method="post"><br>
    <table>
    <tr><td>Login</td><td><input class="textbox" type="text" name="login" size="12" maxlength="20"></td></tr>
    <tr><td>Password</td><td><input class="textbox" type="password" name="pass" size="12" maxlength="20"></td></tr>
    </table>
    <br><input type="submit" value="Login"><br>
    </td></tr><tr><td>
    <center>
<a href="conditions.php">Join The Exchange</a><br><a href="lostpw.php">Lost Password?</a></center>
    </font></form>
    </td></tr></table></td></tr></table>
	
<? include("footer.php"); ?>

