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

while ($get_rows=@mysql_fetch_array($pending)){
	$total_found=mysql_num_rows($pending);
	$found=1;
	$uid=$get_rows[id];
	$ulogin=$get_rows[login];
	?><form action=edit.php method=post>
	<input type="hidden" name=uid value=<?echo "$uid"; ?>>
<input type=hidden name=admlogin value=<? echo "$admlogin"; ?>>
<input type=hidden name=admpass value=<? echo "$admpass"; ?>>
<input type="submit" value="<? echo "$ulogin"; ?>"></form><br>
<?

	}
?>