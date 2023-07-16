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
?><html><head><title><? echo"$exchange_name"; ?> - Sign up!</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body>
<?
$info=mysql_query("select * from banneruser where id='$uid'");
$get_info=mysql_fetch_array($info);
$name=$get_info[name];
$email=$get_info[email];
$oldlogin=$get_info[login];
?>


<CENTER><BR><BR>

<form method="POST" action="infoconfirm.php">
<table cellpadding="4" cellspacing="4" class="windowbg">
<tr colspan=2><b>Change your information</b>
<input type=hidden name=uid value=<? echo "$uid" ?>></td>
<input type=hidden name=oldlogin value=<? echo "$oldlogin" ?>>
    <tr>
      <td width="22%">Real Name:</td>
      <td width="78%"><input type="text" name="name" size="50" value=<? echo "$name" ?>></td>
    </tr>
    <tr>
      <td width="22%">Login ID:</td>
      <td width="78%"><input type="text" name="login" size="50" value=<? echo "$login" ?>></td></td>
    </tr>
    <tr>
      <td width="22%">Password:</td>
      <td width="78%"><input type="text" name="pass" size="50" value=<? echo "$pass" ?>></td>
    </tr>
    <tr>
      <td width="22%">Email Address:</td>
      <td width="78%"><input type="text" name="email" size="50" value=<? echo "$email" ?>></td>
    </tr>
    <tr>
      <td width="22%">&nbsp;</td>
      <td width="78%"><br><br><input type="submit" value=" Press Once to Submit " name="submit">
      <input type="reset" value="Reset"></td>
    </tr>
  </table>
</form>


</CENTER>
<? include("../footer.php"); ?>