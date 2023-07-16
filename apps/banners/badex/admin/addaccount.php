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
		<html><head><title><? echo"$exchange_name"; ?> - Add a New Account</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<br><br>
    <center><h3><? echo "$exchange_name"; ?> - Add a New Account</h3>

<center><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111">
<tr colspan=2><b>Add an Account</b><BR><BR>
<form method="POST" action="addconfirm.php">
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type=hidden name=uid value=<? echo "$uid"; ?>></td>
    <tr>
      <td width="22%">Real Name:</td>
      <td width="78%"><input type="text" name="name" size="50"></td>
    </tr>
    <tr>
      <td width="22%">Login ID:</td>
      <td width="78%"><input type="text" name="login" size="50"></td></td>
    </tr>
    <tr>
      <td width="22%">Password:</td>
      <td width="78%"><input type="text" name="pass" size="50"></td>
    </tr>
    <tr>
      <td width="22%">Email Address:</td>
      <td width="78%"><input type="text" name="email" size="50"></td>
    </tr>
	    <tr>
      <td width="22%">Site URL:</td>
      <td width="78%"><input type="text" name="url" value="http://" size="50"></td>
    </tr>
	    <tr>
      <td width="22%">Exposures:</td>
      <td width="78%"><input type="text" name="exposures" value="0" size="50"></td>
    </tr>
	    <tr>
      <td width="22%">Credits:</td>
      <td width="78%"><input type="text" name="credits" value="0" size="50"></td>
    </tr>
	    <tr>
      <td width="22%">Clicks to Site:</td>
      <td width="78%"><input type="text" name="clicks" value="0" size="50"></td>
    </tr>
	    <tr>
      <td width="22%">Clicks from Site:</td>
      <td width="78%"><input type="text" name="siteclicks" value="0" size="50"></td>
    </tr>
		<tr>
      <td width="22%">Banner URL:</td>
      <td width="78%"><input type="text" name="bannerurl" value="http://" size="50"></td>
    </tr>
	<tr>
      <td width="22%">RAW mode:</td> 
      <td width="78%"><textarea name="rawform" cols="50" rows="5" class="textarea" ></textarea></td>
    </tr>
		    <tr>
      <td width="25%" valign="middle">Account Status:</td>
      <td width="78%" valign="middle">
		
  <input type=radio checked name="approved" value="Approved" class="radio">Approved&nbsp;&nbsp;&nbsp;
  <input type=radio name="approved" class="radio">Not Approved
  </tr>
				    <tr>
      <td width="25%" valign="middle">Default Account:</td>
      <td width="78%" valign="middle">
	 
<input type=radio checked name="defaultacct" class="radio">No&nbsp;&nbsp;&nbsp;
  <input type=radio name="defaultacct" value="defaultacct" class="radio">Yes</td>
      </tr>
</table><br><br>
<input type="submit" value=" Add Account " name="submit">
      <input type="reset" value="Reset this Page"></form>
	  <br><br>

<? include("../footer.php"); ?>
	<?
	}
	?>