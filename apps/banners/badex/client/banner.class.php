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

while ($get_rows=@mysql_fetch_array($banners)){
	$total_found=mysql_num_rows($banners);
	$found=1;
	?>
	  <tr><td width="50%"><center><table border="1" cellpadding="4" cellspacing="4" style="border-collapse: collapse" bordercolor="#666666" width="500" class="windowbg"><tr><td><img src="<?echo"$get_rows[bannerurl]"; ?>"><br>
	  <form action=editbann.php method=post>
	<input type="hidden" name=bannerid value=<?echo "$get_rows[id]"; ?>>
<input type=hidden name=login value=<? echo "$udblogin"; ?>>
<input type=hidden name=pass value=<? echo "$udbpass"; ?>>
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type=text size=50 name=newbanurl value=<? echo "$get_rows[bannerurl]"; ?>> <input type="submit" value="Edit Banner"></form></td></tr></table></center></td>
    <td width="44%"><CENTER><form action=deletebann.php method=post>
	<input type="hidden" name=bannerid value=<?echo "$get_rows[id]"; ?>>
<input type=hidden name=login value=<? echo "$udblogin"; ?>>
<input type=hidden name=pass value=<? echo "$udbpass"; ?>>
<input type=hidden name=uid value=<? echo "$uid"; ?>>
<input type="submit" value="Delete"></CENTER></form>

</td><?
	}
?>