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
?><html><head><title><? echo"$exchange_name"; ?> - Logout</title><LINK REL=stylesheet HREF="../style.css" TYPE="text/css">
</head>
<body>
<center><b>Logout</b><br><br>
<form method="POST" action="<?echo"$base_url";?>/index.php">
<br><br><input type="submit" value="Click Here to log out" name="submit">
</form>
<? include("../footer.php"); ?>