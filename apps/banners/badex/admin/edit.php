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
		<html><head><title><? echo"$exchange_name"; ?> - Edit/Validate Account</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<br><br>
    <center><h3><? echo "$exchange_name"; ?> - Edit/Validate Account</h3>
<?
$info=mysql_query("select * from banneruser where id='$uid'");
$get_info=mysql_fetch_array($info);
$name=$get_info[name];
$email=$get_info[email];
$login=$get_info[login];
$pass=$get_info[pass];
$url=$get_info[url];
$exposures=$get_info[exposures];
$credits=$get_info[credits];
$clicks=$get_info[clicks];
$siteclicks=$get_info[siteclicks];
$approved=$get_info[approved];
$defaultacct=$get_info[defaultacct];
$raw=$get_info[raw];
$rawformatted=htmlspecialchars($raw);
?>
<center><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111">
<tr colspan=2><b>Edit Account <? echo "$login"; ?></b><BR><BR>
<form method="POST" action="editconfirm.php">
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type=hidden name=uid value=<? echo "$uid"; ?>></td>
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
      <td width="22%">Site URL:</td>
      <td width="78%"><input type="text" name="url" size="50" value=<? echo "$url" ?>>[<a href="<? echo "$url"; ?>" target="_blank">Visit</a>]</td>
    </tr>
	    <tr>
      <td width="22%">Exposures:</td>
      <td width="78%"><input type="text" name="exposures" size="50" value=<? echo "$exposures" ?>></td>
    </tr>
	    <tr>
      <td width="22%">Credits:</td>
      <td width="78%"><input type="text" name="credits" size="50" value=<? echo "$credits" ?>></td>
    </tr>
	    <tr>
      <td width="22%">Clicks to Site:</td>
      <td width="78%"><input type="text" name="clicks" size="50" value=<? echo "$clicks" ?>></td>
    </tr>
	    <tr>
      <td width="22%">Clicks from Site:</td>
      <td width="78%"><input type="text" name="siteclicks" size="50" value=<? echo "$siteclicks" ?>></td>
    </tr>
	<tr>
      <td width="22%">RAW mode:</td> 
      <td width="78%">(current): <? echo "$rawformatted"; ?><br><textarea name="rawform" cols="50" rows="5" class="textarea" ></textarea></td>
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
	  <?
	  if($defaultacct==1){
	  ?>
<input type=radio name="defaultacct" class="radio">No&nbsp;&nbsp;&nbsp;
  <input type=radio checked name="defaultacct" value="defaultacct" class="radio">Yes</td>
      </tr>
</table>
  <?
  }else{
	  ?>
  <input type=radio checked name="defaultacct" class="radio">No&nbsp;&nbsp;&nbsp;
  <input type=radio name="defaultacct" value="defaultacct" class="radio">Yes</td>
    </tr>
</table>
<?
  }
  ?>
<input type="submit" value=" Validate Account " name="submit">
      <input type="reset" value="Reset this Page"></form>
	  <form method="POST" action="delraw.php">
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type="submit" value="Remove RAW HTML" name="submit"></form>

	  <form method="POST" action="deleteacct.php">
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=login value=<? echo "$login"; ?>>
<input type="submit" value=" Delete Account " name="submit"></form>

 <table border="0" cellpadding="4" cellspacing="4" style="border-collapse: collapse" bordercolor="#111111" width="600" class="windowbg">
  <tr>
    <td width="44%" colspan="2">
    <p align="center"><B>Active Banners For <? echo "$login"; ?></B></td>
  </tr><?
//let's get some banners
$banners = mysql_query("select * from bannerurls where uid='$uid'");
	$found = 0;
	include("banner.class.php");
	if($found == 0){
		echo "</tr></table>No Banners Found for this account!</center>";
	} else {
		  ?> </tr>
</table><?
echo "".$total_found." banners found for this account.</center><br><br>";
	}
			?>
		<form action=addbann.php method=post>
	<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type=text size=50 name=bannerurl value=http://> 
<input type="submit" value=" Add Banner ">
<center>
	  <br><br>

<? include("../footer.php"); ?>
	<?
	}
	?>