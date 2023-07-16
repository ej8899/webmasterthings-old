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
?><html><head><title><? echo"$exchange_name"; ?> - Sign up!</title><LINK REL=stylesheet HREF="style.css" TYPE="text/css">
</head>
<body>
<form method="POST" action="signupconfirm.php">
<CENTER>
<table border="0" cellpadding="4" cellspacing="4" Class="windowbg">
<tr colspan=2><b>Sign Up for <? echo "$exchange_name";?></b>
    <tr>
      <td width="22%">Real Name:</td>
      <td width="78%"><input type="text" name="name" size="15"></td>
    </tr>
    <tr>
      <td width="22%">Login ID:</td>
      <td width="78%"><input type="text" name="login" size="15" maxlength="20"></td>
    </tr>
    <tr>
      <td width="22%">Password:</td>
      <td width="78%"><input type="text" name="pass" size="15" maxlength="20"></td>
    </tr>
    <tr>
      <td width="22%">Email Address:</td>
      <td width="78%"><input type="text" name="email" size="20"></td>
    </tr>
    <tr>
      <td width="22%">Site URL:</td>
      <td width="78%"><input type="text" name="url" size="30" value="http://"></td>
    </tr>
	    <tr>
      <td width="22%">Banner URL:</td>
      <td width="78%"><input type="text" name="bannerurl" size="30" value="http://"></td>
    </tr>
    <tr>
      <td width="22%">&nbsp;</td>
      <td width="78%"><p><input type="submit" value=" Press Once to Submit " name="submit">
      <input type="reset" value="Reset"></td>
    </tr>
  </table>
</CENTER>
</form>
<? include("footer.php"); ?>