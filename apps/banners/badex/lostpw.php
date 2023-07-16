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
		<html><head><title><? echo"$exchange_name"; ?> - Lost Password</title><LINK REL=stylesheet HREF="<?echo "$base_url" ?>/style.css" TYPE="text/css">
</head>
<body>
<p>
    <center><b>Please type in your username/login ID:</b><br>
	<form method="POST" action="lostpwconfirm.php">
<input type=text name=login size=40>
<input type="submit" value="Send Password">
</form>
<p>
<? include("footer.php"); ?>